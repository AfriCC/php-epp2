<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame;

use AfriCC\EPP\Frame;
use AfriCC\EPP\ObjectSpec;
use Exception;

class Command extends Frame
{
    protected $knownCommands = array(
    	'check' => true,
        'info' => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'renew' => true,
        'transfer' => true,
        'poll' => true,
        'login' => true,
        'logout' => true,
    );

    public function __construct($command, $type = '')
    {
        $this->type = $type;
        $command = strtolower($command);
        if (!isset($this->knownCommands[$command])) {
            throw new Exception(sprintf('unknown command: %s', $command));
        }

        parent::__construct('command');

        $this->command = $this->createElement($command);
        $this->body->appendChild($this->command);

        if (!empty($this->type)) {
            $this->payload = $this->createElementNS(
                Net_EPP_ObjectSpec::xmlns($this->type),
                $this->type.':'.$command
            );

            $this->command->appendChild($this->payload);
        }

        $this->clTRID = $this->createElement('clTRID');
        $this->clTRID->appendChild($this->createTextNode(''));
        $this->body->appendChild($this->clTRID);
    }

    function addObjectProperty($name, $value = null)
    {
        $element = $this->createObjectPropertyElement($name);
        $this->payload->appendChild($element);

        if ($value instanceof DomNode) {
            $element->appendChild($value);

        } elseif (isset($value)) {
            $element->appendChild($this->createTextNode($value));

        }

        return $element;
    }

    function createObjectPropertyElement($name)
    {
        return $this->createElementNS(
            ObjectSpec::xmlns($this->type),
            $this->type.':'.$name
        );
    }

    function createExtensionElement($ext, $command)
    {
        $this->extension = $this->createElement('extension');
        $this->body->appendChild($this->extension);

        $this->extension->payload = $this->createElementNS(
            Net_EPP_ObjectSpec::xmlns($ext),
            $ext.':'.$command
        );

        $this->extension->appendChild($this->extension->payload);
    }
}
