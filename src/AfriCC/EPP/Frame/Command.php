<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame;

use AfriCC\EPP\TransactionAwareInterface;
use AfriCC\EPP\AbstractFrame;
use AfriCC\EPP\ObjectSpec;
use Exception;
use DOMNode;

class Command extends AbstractFrame implements TransactionAwareInterface
{
    protected $format_name = 'command';
    protected $command_name;
    protected $command;
    protected $client_transaction_id;

    public function __construct()
    {
        parent::__construct();

        $this->command = $this->createElement($this->command_name);
        $this->body->appendChild($this->command);

        if (!empty($this->mapping_name)) {
            $this->payload = $this->createElementNS(
                ObjectSpec::xmlns($this->mapping_name),
                $this->mapping_name . ':' . $this->command_name
            );

            $this->command->appendChild($this->payload);
        }

        $this->client_transaction_id = $this->createElement('clTRID');
        $this->client_transaction_id->appendChild($this->createTextNode(''));
        $this->body->appendChild($this->client_transaction_id);
    }

    public function addObjectProperty($name, $value = null, $dst = null)
    {
        $element = $this->createObjectPropertyElement($name);

        if ($dst === null) {
            $this->payload->appendChild($element);
        } else {
            $dst->appendChild($element);
        }

        if ($value instanceof DOMNode) {
            $element->appendChild($value);
        } elseif (isset($value)) {
            $element->appendChild($this->createTextNode($value));
        }

        return $element;
    }

    public function createObjectPropertyElement($name)
    {
        return $this->createElementNS(
            ObjectSpec::xmlns($this->mapping_name),
            $this->mapping_name . ':' . $name
        );
    }

    public function createExtensionElement($ext, $command)
    {
        $this->extension = $this->createElement('extension');
        $this->body->appendChild($this->extension);

        $this->extension->payload = $this->createElementNS(
            ObjectSpec::xmlns($ext),
            $ext.':'.$command
        );

        $this->extension->appendChild($this->extension->payload);
    }

    public function setClientTransactionId($cltrid) {
        $this->client_transaction_id->nodeValue = $cltrid;
    }

    public function getClientTransactionId() {
        return $this->client_transaction_id->nodeValue;
    }
}
