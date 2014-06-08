<?php
/**
 * A simple client class for the Extensible Provisioning Protocol (EPP)
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP;

class Client
{
    /**
    * @var resource the socket resource, once connected
    */
    var $socket;

    /**
    * Establishes a connect to the server
    * This method establishes the connection to the server. If the connection was
    * established, then this method will call getFrame() and return the EPP <greeting>
    * frame which is sent by the server upon connection. If connection fails, then
    * an exception with a message explaining the error will be thrown and handled
    * in the calling code.
    * @param string $host the hostname
    * @param integer $port the TCP port
    * @param integer $timeout the timeout in seconds
    * @param boolean $ssl whether to connect using SSL
    * @param resource $context a stream resource to use when setting up the socket connection
    * @throws Exception on connection errors
    * @return a string containing the server <greeting>
    */
    function connect($host, $port=700, $timeout=1, $ssl=true, $context=NULL)
    {
        $target = sprintf('%s://%s:%d', ($ssl === true ? 'tls' : 'tcp'), $host, $port);
        if (is_resource($context)) {
            $result = stream_socket_client($target, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);

        } else {
            $result = stream_socket_client($target, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT);
        }
        if ($result === False) {
            throw new Exception("Error connecting to $target: $errstr (code $errno)");

        }

        // Set our socket
        $this->socket = $result;

        // Set stream timeout
        if (!stream_set_timeout($this->socket,$timeout)) {
            throw new Exception("Failed to set timeout on socket: $errstr (code $errno)");
        }
        // Set blocking
        if (!stream_set_blocking($this->socket,0)) {
            throw new Exception("Failed to set blocking on socket: $errstr (code $errno)");
        }

        return $this->getFrame();
    }

    /**
    * Get an EPP frame from the server.
    * This retrieves a frame from the server. Since the connection is blocking, this
    * method will wait until one becomes available. If the connection has been broken,
    * this method will return a string containing the XML from the server
    * @throws Exception on frame errors
    * @return a string containing the frame
    */
    function getFrame()
    {
        return Net_EPP_Protocol::getFrame($this->socket);
    }

    /**
    * Send an XML frame to the server.
    * This method sends an EPP frame to the server.
    * @param string the XML data to send
    * @throws Exception when it doesn't complete the write to the socket
    * @return boolean the result of the fwrite() operation
    */
    function sendFrame($xml)
    {
        return Net_EPP_Protocol::sendFrame($this->socket, $xml);
    }

    /**
    * a wrapper around sendFrame() and getFrame()
    * @param string $xml the frame to send to the server
    * @throws Exception when it doesn't complete the write to the socket
    * @return string the frame returned by the server, or an error object
    */
    function request($xml)
    {
        $res = $this->sendFrame($xml);

        return $this->getFrame();
    }

    /**
    * Close the connection.
    * This method closes the connection to the server. Note that the
    * EPP specification indicates that clients should send a <logout>
    * command before ending the session.
    * @return boolean the result of the fclose() operation
    */
    function disconnect()
    {
        return @fclose($this->socket);
    }

    /**
    * ping the connection to check that it's up
    * @return boolean
    */
    function ping()
    {
        return (!is_resource($this->socket) || feof($this->socket) ? false : true);
    }

}
