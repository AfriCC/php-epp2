<?php

namespace AfriCC\EPP;

use AfriCC\EPP\Frame\Command\Login as LoginCommand;
use AfriCC\EPP\Frame\Response as ResponseFrame;
use AfriCC\EPP\Frame\ResponseFactory;
use Exception;

/**
 * An abstract client client for the Extensible Provisioning Protocol (EPP)
 *
 * Extend this class in your custom EPP Client
 *
 * @see http://tools.ietf.org/html/rfc5734
 * @see ClientInterface
 *
 * As this class is abstract and relies on subclass implementation details it's untestable
 * @codeCoverageIgnore
 */
abstract class AbstractClient implements ClientInterface
{
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $lang;
    protected $version;
    protected $services;
    protected $serviceExtensions;
    protected $ssl;
    protected $local_cert;
    protected $ca_cert;
    protected $pk_cert;
    protected $passphrase;
    protected $debug;
    protected $connect_timeout;
    protected $timeout;
    protected $objectSpec;

    /**
     * {@inheritdoc}
     *
     * @see \AfriCC\EPP\ClientInterface::connect()
     */
    abstract public function connect($newPassword = false);

    abstract public function close();

    abstract protected function log($message);

    /**
     * Send frame to EPP server
     *
     * @param FrameInterface $frame Frame to send
     *
     * @throws Exception on send error
     */
    abstract public function sendFrame(FrameInterface $frame);

    /**
     * Get response frame from EPP server (use after sendFrame)
     *
     * @throws Exception on frame receive error
     *
     * @return string raw XML of EPP Frame
     */
    abstract public function getFrame();

    public function request(FrameInterface $frame)
    {
        if ($frame instanceof TransactionAwareInterface) {
            $frame->setClientTransactionId(
                $this->generateClientTransactionId()
                );
        }

        $this->sendFrame($frame);

        $return = $this->getFrame();

        return ResponseFactory::build($return, $this->objectSpec);
    }

    public function __construct(array $config, ObjectSpec $objectSpec = null)
    {
        if (!empty($config['debug']) && is_bool($config['debug'])) {
            $this->debug = $config['debug'];
        } else {
            $this->debug = false;
        }

        if (is_null($objectSpec)) {
            $objectSpec = new ObjectSpec();
        }

        $this->objectSpec = $objectSpec;

        $this->prepareConnectionOptions($config);
        $this->prepareCredentials($config);
        $this->prepareSSLOptions($config);
        $this->prepareEPPServices($config);
        $this->prepareEPPVersionLang($config);
    }

    /**
     * Get client's ObjectSpec
     *
     * @return ObjectSpec
     */
    public function getObjectSpec()
    {
        return $this->objectSpec;
    }

    /**
     * Set client's ObjectSpec
     *
     * @param ObjectSpec $newObjectSpec
     */
    public function setObjectSpec(ObjectSpec $newObjectSpec)
    {
        $this->objectSpec = $newObjectSpec;
    }

    /**
     * Get config value from config array if set (default otherwise)
     *
     * Basically, a simple null coallesce operator (since we need to support PHP 5.5)
     *
     * @param array $config
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    protected function getConfigDefault(array $config, string $key, $default = null)
    {
        if (!empty($config[$key])) {
            return $config[$key];
        }

        return $default;
    }

    /**
     * Get config value from config array if set (default otherwise)
     *
     * special version for bool values
     *
     * @param array $config
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     *
     * @see AbstractClient::getConfigDefault
     */
    protected function getConfigDefaultBool(array $config, string $key, $default = null)
    {
        if (isset($config[$key]) && is_bool($config[$key])) {
            return $config[$key];
        }

        return $default;
    }

    /**
     * Get config value from config array if set (default otherwise)
     *
     * special version for aray values
     *
     * @param array $config
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     *
     * @see AbstractClient::getConfigDefault
     */
    protected function getConfigDefaultArray(array $config, string $key, $default = null)
    {
        if (!empty($config[$key]) && is_array($config[$key])) {
            return $config[$key];
        }

        return $default;
    }

    /**
     * Get config value from config array if set (default otherwise)
     *
     * special version for files
     *
     * @param array $config
     * @param string $key
     * @param mixed $default
     *
     * @throws Exception in case file is specified but not readable
     *
     * @return mixed
     *
     * @see AbstractClient::getConfigDefault
     */
    protected function getConfigDefaultReadableFile(array $config, string $key, $default = null)
    {
        if (!empty($config[$key])) {
            $return = (string) $config[$key];

            if (!is_readable($return)) {
                throw new \Exception(sprintf('unable to read %s: %s', $key, $return));
            }

            return $return;
        }

        return $default;
    }

    protected function prepareConnectionOptions(array $config)
    {
        $this->host = $this->getConfigDefault($config, 'host');
        $this->port = $this->getConfigDefault($config, 'port', false);
        $this->connect_timeout = (int) $this->getConfigDefault($config, 'connect_timeout', 16);
        $this->timeout = (int) $this->getConfigDefault($config, 'timeout', 32);
    }

    protected function prepareCredentials(array $config)
    {
        $this->username = $this->getConfigDefault($config, 'username');
        $this->password = $this->getConfigDefault($config, 'password');
    }

    protected function prepareSSLOptions(array $config)
    {
        $this->ssl = $this->getConfigDefaultBool($config, 'ssl', false);

        $this->local_cert = $this->getConfigDefaultReadableFile($config, 'local_cert');
        $this->ca_cert = $this->getConfigDefaultReadableFile($config, 'ca_cert');
        $this->pk_cert = $this->getConfigDefaultReadableFile($config, 'pk_cert');

        $this->passphrase = $this->getConfigDefault($config, 'passphrase');
    }

    protected function prepareEPPServices(array $config)
    {
        $this->services = $this->getConfigDefaultArray($config, 'services');
        $this->serviceExtensions = $this->getConfigDefaultArray($config, 'serviceExtensions');
    }

    protected function prepareEPPVersionLang(array $config)
    {
        $this->lang = $this->getConfigDefault($config, 'lang', 'en');
        $this->version = $this->getConfigDefault($config, 'version', '1.0');
    }

    protected function generateClientTransactionId()
    {
        return Random::id(64, $this->username);
    }

    /**
     * Generate and send login frame
     *
     * @param bool|string $newPassword New password to set on login, false if not changing password
     *
     * @throws \Exception On unsuccessful login
     *
     * @return \AfriCC\EPP\Frame\Response Login response
     */
    protected function login($newPassword = false)
    {
        // send login command
        $login = new LoginCommand($this->objectSpec);
        $login->setClientId($this->username);
        $login->setPassword($this->password);
        if ($newPassword) {
            $login->setNewPassword($newPassword);
        }
        $login->setVersion($this->version);
        $login->setLanguage($this->lang);

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
            throw new \Exception('there was a problem logging onto the EPP server');
        } elseif ($response->code() !== 1000) {
            throw new \Exception($response->message(), $response->code());
        }

        return $response;
    }
}
