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
use DOMNode;

class Command extends Frame
{
    protected $format_name = 'command';
    protected $command_name;
    protected $command;

    public function __construct()
    {
        parent::__construct();

        $this->command = $this->createElement($this->command_name);
        $this->body->appendChild($this->command);

        if (!empty($this->mapping_name)) {
            $this->payload = $this->createElementNS(
                ObjectSpec::xmlns($this->mapping_name),
                $this->mapping_name.':'. $this->command_name
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
        $this->command->appendChild($element);

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
            ObjectSpec::xmlns($this->mapping_name),
            $this->type.':'.$name
        );
    }

    function createExtensionElement($ext, $command)
    {
        $this->extension = $this->createElement('extension');
        $this->body->appendChild($this->extension);

        $this->extension->payload = $this->createElementNS(
            ObjectSpec::xmlns($ext),
            $ext.':'.$command
        );

        $this->extension->appendChild($this->extension->payload);
    }
}
