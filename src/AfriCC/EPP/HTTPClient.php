<?php

namespace AfriCC\EPP;

use AfriCC\EPP\Frame\Command\Logout as LogoutCommand;

/**
 * A high level HTTP(S) based client for the Extensible Provisioning Protocol (EPP)
 *
 * @see http://tools.ietf.org/html/rfc5734
 *
 * As this class deals directly with cURL it's untestable
 * @codeCoverageIgnore
 */
class HTTPClient extends AbstractClient implements ClientInterface
{
    protected $curl;
    protected $cookiejar;

    public function __construct(array $config, ObjectSpec $objectSpec = null)
    {
        parent::__construct($config, $objectSpec);

        $proto = \parse_url($this->host, PHP_URL_SCHEME);
        if ($proto == 'https') {
            $this->ssl = true;
        } else {
            $this->ssl = false;
        }

        $this->prepareCookieJar($config);
    }

    protected function prepareCookieJar(array $config)
    {
        $this->cookiejar = $this->getConfigDefault($config, 'cookiejar', tempnam(sys_get_temp_dir(), 'ehc'));

        if (!is_readable($this->cookiejar) || !is_writable($this->cookiejar)) {
            throw new \Exception(
                sprintf(
                    'unable to read/write cookiejar: %s',
                    $this->cookiejar
                    )
                );
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    private function setupCurl()
    {
        $this->curl = curl_init($this->host);

        if ($this->curl === false) {
            throw new \Exception('Cannot initialize cURL extension');
        }

        $this->setupCurlOpts();

        // certs
        if ($this->ssl) {
            $this->setupCurlSSL();
        }
    }

    private function setupCurlOpts()
    {
        // set stream time out
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt(
            $this->curl,
            CURLOPT_CONNECTTIMEOUT,
            $this->connect_timeout
            );

        // set necessary options
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_HEADER, false);

        // cookies
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookiejar);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookiejar);
    }

    private function setupCurlSSL()
    {
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($this->curl, CURLOPT_SSLKEYTYPE, 'PEM');

        if ($this->ca_cert) {
            curl_setopt($this->curl, CURLOPT_CAINFO, $this->ca_cert);
        }
        if ($this->pk_cert) {
            curl_setopt($this->curl, CURLOPT_SSLKEY, $this->pk_cert);
        }
        if ($this->local_cert) {
            curl_setopt($this->curl, CURLOPT_SSLCERT, $this->local_cert);
        }
        if ($this->passphrase) {
            curl_setopt($this->curl, CURLOPT_SSLCERTPASSWD, $this->passphrase);
        }
    }

    /**
     * Open a new connection to the EPP server
     *
     * @param bool|string $newPassword String with new password to set upon login, false if no password
     */
    public function connect($newPassword = false)
    {
        $this->setupCurl();

        // get greeting
        $greeting = $this->request(new \AfriCC\EPP\Frame\Hello($this->objectSpec));

        // login
        $this->login($newPassword);

        // return greeting
        return $greeting;
    }

    /**
     * Closes a previously opened EPP connection
     */
    public function close()
    {
        if ($this->active()) {
            // send logout frame
            $this->request(new LogoutCommand($this->objectSpec));

            return curl_close($this->curl);
        }

        return false;
    }

    public function sendFrame(FrameInterface $frame)
    {
        $content = (string) $frame;
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $content);
    }

    public function getFrame()
    {
        $return = curl_exec($this->curl);

        if ($return === false) {
            $code = curl_errno($this->curl);
            $msg = curl_error($this->curl);
            throw new \Exception($msg, $code);
        }

        return $return;
    }

    protected function log($message)
    {
        if ($this->debug) {
            \error_log($message);
        }
    }

    /**
     * Check if curl session is still active
     *
     * @return bool
     */
    private function active()
    {
        return is_resource($this->curl);
    }
}
