<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

use AfriCC\EPP\Frame\ResponseFactory;
use AfriCC\EPP\Frame\Response as ResponseFrame;
use AfriCC\EPP\Frame\Hello as HelloFrame;
use AfriCC\EPP\Frame\Command\Login as LoginCommand;
use AfriCC\EPP\Frame\Command\Logout as LogoutCommand;
use Exception;

/**
 * A high level TCP (SSL) based client for the Extensible Provisioning Protocol (EPP)
 * @link http://tools.ietf.org/html/rfc5734
 */
class Client
{
    protected $socket;
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $services;
    protected $serviceExtensions;
    protected $protocol;
    protected $local_cert;
    protected $passphrase;
    protected $debug;
    protected $connect_timeout;
    protected $timeout;
    protected $chunk_size;
    protected $curl_cookie;

    public function __construct(array $config)
    {
        if (!empty($config['host'])) {
            $this->host = (string) $config['host'];
        }

        if (!empty($config['port'])) {
            $this->port = (int) $config['port'];
        } else {
            $this->port = 700;
        }

        if (!empty($config['username'])) {
            $this->username = (string) $config['username'];
        }

        if (!empty($config['password'])) {
            $this->password = (string) $config['password'];
        }

        if (!empty($config['services']) && is_array($config['services'])) {
            $this->services = $config['services'];

            if (!empty($config['serviceExtensions']) && is_array($config['serviceExtensions'])) {
                $this->serviceExtensions = $config['serviceExtensions'];
            }
        }

        if (!empty($config['protocol'])) {
            $this->protocol = (string) $config['protocol'];
        }

        if (!empty($config['local_cert'])) {
            $this->local_cert = (string) $config['local_cert'];

            if (!is_readable($this->local_cert)) {
                throw new Exception(sprintf('unable to read local_cert: %s', $this->local_cert));
            }

            if (!empty($config['passphrase'])) {
                $this->passphrase = $config['passphrase'];
            }
        }

        if (!empty($config['debug'])) {
            $this->debug = true;
        } else {
            $this->debug = false;
        }

        if (!empty($config['connect_timeout'])) {
            $this->connect_timeout = (int) $config['connect_timeout'];
        } else {
            $this->connect_timeout = 4;
        }

        if (!empty($config['timeout'])) {
            $this->timeout = (int) $config['timeout'];
        } else {
            $this->timeout = 8;
        }

        if (!empty($config['chunk_size'])) {
            $this->chunk_size = (int) $config['chunk_size'];
        } else {
            $this->chunk_size = 1024;
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * Open a new connection to the EPP server
     */
    public function connect()
    {
        if ($this->protocol == 'http' || $this->protocol == 'https') {
            $proto = $this->protocol;
        } elseif ($this->protocol == 'ssl' || $this->protocol == 'tls') {
            $proto = $this->protocol;

            $context = stream_context_create();
            stream_context_set_option($context, 'ssl', 'verify_peer', false);
            stream_context_set_option($context, 'ssl', 'allow_self_signed', true);

            if ($this->local_cert !== null) {
                stream_context_set_option($context, 'ssl', 'local_cert', $this->local_cert);

                if ($this->passphrase) {
                    stream_context_set_option($context, 'ssl', 'passphrase', $this->passphrase);
                }
            }
        } else {
            $proto = 'tcp';
        }

        if ($this->protocol != 'http' && $this->protocol != 'https') {
            $target = sprintf('%s://%s:%d', $proto, $this->host, $this->port);

            if (isset($context) && is_resource($context)) {
                $this->socket = @stream_socket_client($target, $errno, $errstr, $this->connect_timeout, STREAM_CLIENT_CONNECT, $context);
            } else {
                $this->socket = @stream_socket_client($target, $errno, $errstr, $this->connect_timeout, STREAM_CLIENT_CONNECT);
            }

            if ($this->socket === false) {
                throw new Exception($errstr, $errno);
            }

            // set stream time out
            if (!stream_set_timeout($this->socket, $this->timeout)) {
                throw new Exception('unable to set stream timeout');
            }

            // set to non-blocking
            if (!stream_set_blocking($this->socket, 0)) {
                throw new Exception('unable to set blocking');
            }
        }

        // get greeting
        if ($this->protocol == 'http' || $this->protocol == 'https') {
            $frame = new HelloFrame;
            $greeting = $this->request($frame);
        } else {
            $greeting = $this->getFrame();
        }

        // login
        $this->login();

        // return greeting
        return $greeting;
    }

    /**
     * Closes a previously opened EPP connection
     */
    public function close()
    {
        if ($this->protocol == 'http' || $this->protocol == 'https') {
            // send logout frame
            $this->request(new LogoutCommand);
            return true;
        } else {
            if ($this->active()) {
                // send logout frame
                $this->request(new LogoutCommand);
                return fclose($this->socket);
            }
            return false;
        }
    }

    /**
     * Get an EPP frame from the server.
     */
    public function getFrame()
    {
        $header = $this->recv(4);

        // Unpack first 4 bytes which is our length
        $unpacked = unpack('N', $header);
        $length = $unpacked[1];

        if ($length < 5) {
            throw new Exception(sprintf('Got a bad frame header length of %d bytes from peer', $length));
        } else {
            $length -= 4;
            return ResponseFactory::build($this->recv($length));
        }
    }

    /**
     * sends a XML-based frame to the server
     * @param FrameInterface $frame the frame to send to the server
     */
    public function sendFrame(FrameInterface $frame)
    {
        // some frames might require a client transaction identifier, so let us
        // inject it before sending the frame
        if ($frame instanceof TransactionAwareInterface) {
            $frame->setClientTransactionId($this->generateClientTransactionId());
        }

        if ($this->protocol == 'http' || $this->protocol == 'https') {
            if ($this->port == 80 || $this->port == 443) {
                $target = sprintf('%s://%s', $this->protocol, $this->host);
            } else {
                $target = sprintf('%s://%s:%d', $this->protocol, $this->host, $this->port);
            }

            $curlHandle = curl_init();

            curl_setopt($curlHandle, CURLOPT_URL, $target);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlHandle, CURLOPT_POST, 1);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, trim($frame));
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

            if ($this->local_cert !== null) {
                curl_setopt($curlHandle, CURLOPT_SSLCERT, $this->local_cert);
                if ($this->passphrase) {
                    curl_setopt($curlHandle, CURLOPT_SSLCERTPASSWD, $this->passphrase);
                }
            }

            if ($this->curl_cookie !== null) {
                curl_setopt($curlHandle, CURLOPT_COOKIE, $this->curl_cookie);
            }

            curl_setopt($curlHandle, CURLINFO_HEADER_OUT, 1);
            curl_setopt($curlHandle, CURLOPT_HEADER, 1);

            $response = curl_exec($curlHandle);

            if ($response === false) {
                $curlerror = curl_error($curlHandle);
                curl_close($curlHandle);
                throw new Exception($curlerror.' ('.$target.')');
            } else {
                $header_size = curl_getinfo($curlHandle, CURLINFO_HEADER_SIZE);
                $curlHeader = substr($response, 0, $header_size);
                $res = substr($response, $header_size);
                curl_close($curlHandle);
            }

            $curlHeader = $this->httpParseHeaders($curlHeader);

            if (!empty($curlHeader['Set-Cookie'])) {
                $this->curl_cookie = $curlHeader['Set-Cookie'];
            }

            return $res;
        } else {
            $buffer = (string) $frame;
            $header = pack('N', mb_strlen($buffer, 'ASCII') + 4);
            return $this->send($header.$buffer);
        }
    }

    /**
     * a wrapper around sendFrame() and getFrame()
     */
    public function request(FrameInterface $frame)
    {
        if ($this->protocol == 'http' || $this->protocol == 'https') {
            return $this->sendFrame($frame);
        } else {
            $this->sendFrame($frame);

            return $this->getFrame();
        }
    }

    /**
     * check if socket is still active
     * @return boolean
     */
    public function active()
    {
        return (!is_resource($this->socket) || feof($this->socket) ? false : true);
    }

    protected function login()
    {
        // send login command
        $login = new LoginCommand;
        $login->setClientId($this->username);
        $login->setPassword($this->password);
        $login->setVersion('1.0');
        $login->setLanguage('en');

        if (!empty($this->services) && is_array($this->services)) {
            foreach ($this->services as $urn) {
                $login->addService($urn);
            }

            if (!empty($this->serviceExtensions) && is_array($this->serviceExtensions)) {
                foreach ($this->serviceExtensions as $extension) {
                    $login->addServiceExtension($extension);
                }
            }
        }

        $response = $this->request($login);
        unset($login);

        // check if login was successful
        if (!($response instanceof ResponseFrame)) {
            throw new Exception('there was a problem logging onto the EPP server');
        } elseif ($response->code() !== 1000) {
            throw new Exception($response->message(), $response->code());
        }
    }

    protected function log($message, $color = '0;32')
    {
        if ($message === '') {
            return;
        }
        echo sprintf("\033[%sm%s\033[0m", $color, $message);
    }

    protected function generateClientTransactionId()
    {
        return Random::id(64, $this->username);
    }

    /**
     * receive socket data
     * @param int $length
     * @throws Exception
     * @return string
     */
    private function recv($length)
    {
        $result = '';

        $info = stream_get_meta_data($this->socket);
        $hard_time_limit = time() + $this->timeout + 2;

        while (!$info['timed_out'] && !feof($this->socket)) {

            // Try read remaining data from socket
            $buffer = @fread($this->socket, $length - mb_strlen($result, 'ASCII'));

            // If the buffer actually contains something then add it to the result
            if ($buffer !== false) {
                if ($this->debug) {
                    $this->log($buffer);
                }

                $result .= $buffer;

                // break if all data received
                if (mb_strlen($result, 'ASCII') === $length) {
                    break;
                }
            } else {
                // sleep 0.25s
                usleep(250000);
            }

            // update metadata
            $info = stream_get_meta_data($this->socket);
            if (time() >= $hard_time_limit) {
                throw new Exception('Timeout while reading from EPP Server');
            }
        }

        // check for timeout
        if ($info['timed_out']) {
            throw new Exception('Timeout while reading data from socket');
        }

        return $result;
    }

    /**
     * send data to socket
     * @param string $buffer
     */
    private function send($buffer)
    {
        $info = stream_get_meta_data($this->socket);
        $hard_time_limit = time() + $this->timeout + 2;
        $length = mb_strlen($buffer, 'ASCII');

        $pos = 0;
        while (!$info['timed_out'] && !feof($this->socket)) {
            // Some servers don't like alot of data, so keep it small per chunk
            $wlen = $length - $pos;

            if ($wlen > $this->chunk_size) {
                $wlen = $this->chunk_size;
            }

            // try write remaining data from socket
            $written = @fwrite($this->socket, mb_substr($buffer, $pos, $wlen, 'ASCII'), $wlen);

            // If we read something, bump up the position
            if ($written) {
                if ($this->debug) {
                    $this->log(mb_substr($buffer, $pos, $wlen, 'ASCII'), '1;31');
                }
                $pos += $written;

                // break if all written
                if ($pos === $length) {
                    break;
                }
            } else {
                // sleep 0.25s
                usleep(250000);
            }

            // update metadata
            $info = stream_get_meta_data($this->socket);
            if (time() >= $hard_time_limit) {
                throw new Exception('Timeout while writing to EPP Server');
            }
        }

        // check for timeout
        if ($info['timed_out']) {
            throw new Exception('Timeout while writing data to socket');
        }

        if ($pos !== $length) {
            throw new Exception('Writing short %d bytes', $length - $pos);
        }

        return $pos;
    }

    private function httpParseHeaders($header) {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        foreach( $fields as $field ) {
            if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
                $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
                if( isset($retVal[$match[1]]) ) {
                    if ( is_array( $retVal[$match[1]] ) ) {
                        $i = count($retVal[$match[1]]);
                        $retVal[$match[1]][$i] = $match[2];
                    }
                    else {
                        $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                    }
                } else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
        }
        return $retVal;
    }
}
