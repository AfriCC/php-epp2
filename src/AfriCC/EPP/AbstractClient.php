<?php

namespace AfriCC\EPP;

use AfriCC\EPP\Frame\Command\Login as LoginCommand;
use AfriCC\EPP\Frame\Response as ResponseFrame;
use AfriCC\EPP\Frame\ResponseFactory;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

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
abstract class AbstractClient implements ClientInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $host;
    protected $port;
    protected $username;
    protected $password;
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

    /**
     * Prints out debugging data (eg raw frame bytes)
     *
     * @param string $message
     */
    abstract protected function debugLog($message);

    protected function logCommand(FrameInterface $frame)
    {
        if (isset($this->logger)) {
            $command = \get_class($frame);
            $frame_xml = (string) $frame;
            $this->logger->info("Sending EPP Command '$command'. Full frame: $frame_xml");
        }
    }

    protected function logResponse(ResponseFrame $frame)
    {
        if (isset($this->logger)) {
            $type = \get_class($frame);
            $frame_xml = (string) $frame;
            $this->logger->info("Received EPP Response '$type'. Full frame: $frame_xml");
        }
    }

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

        $this->logCommand($frame);
        $this->sendFrame($frame);

        $return = $this->getFrame();
        $response = ResponseFactory::build($return, $this->objectSpec);
        $this->logResponse($response);

        return $response;
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

    protected function prepareConnectionOptions(array $config)
    {
        if (!empty($config['host'])) {
            $this->host = (string) $config['host'];
        }

        if (!empty($config['port'])) {
            $this->port = (int) $config['port'];
        } else {
            $this->port = false;
        }

        if (!empty($config['connect_timeout'])) {
            $this->connect_timeout = (int) $config['connect_timeout'];
        } else {
            $this->connect_timeout = 16;
        }

        if (!empty($config['timeout'])) {
            $this->timeout = (int) $config['timeout'];
        } else {
            $this->timeout = 32;
        }
    }

    protected function prepareCredentials(array $config)
    {
        if (!empty($config['username'])) {
            $this->username = (string) $config['username'];
        }

        if (!empty($config['password'])) {
            $this->password = (string) $config['password'];
        }
    }

    protected function prepareSSLOptions(array $config)
    {
        if ((!empty($config['ssl']) && is_bool($config['ssl']))) {
            $this->ssl = $config['ssl'];
        } else {
            $this->ssl = false;
        }

        if (!empty($config['local_cert'])) {
            $this->local_cert = (string) $config['local_cert'];

            if (!is_readable($this->local_cert)) {
                throw new \Exception(sprintf('unable to read local_cert: %s', $this->local_cert));
            }
        }

        if (!empty($config['ca_cert'])) {
            $this->ca_cert = (string) $config['ca_cert'];

            if (!is_readable($this->ca_cert)) {
                throw new \Exception(sprintf('unable to read ca_cert: %s', $this->ca_cert));
            }
        }

        if (!empty($config['pk_cert'])) {
            $this->pk_cert = (string) $config['pk_cert'];

            if (!is_readable($this->pk_cert)) {
                throw new \Exception(sprintf('unable to read pk_cert: %s', $this->pk_cert));
            }
        }

        if (!empty($config['passphrase'])) {
            $this->passphrase = (string) $config['passphrase'];
        }
    }

    protected function prepareEPPServices(array $config)
    {
        if (!empty($config['services']) && is_array($config['services'])) {
            $this->services = $config['services'];

            if (!empty($config['serviceExtensions']) && is_array($config['serviceExtensions'])) {
                $this->serviceExtensions = $config['serviceExtensions'];
            }
        }
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
            throw new \Exception('there was a problem logging onto the EPP server');
        } elseif ($response->code() !== 1000) {
            throw new \Exception($response->message(), $response->code());
        }

        return $response;
    }
}
