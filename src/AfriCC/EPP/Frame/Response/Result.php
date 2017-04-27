<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Response;

use AfriCC\EPP\DOM\DOMTools;
use DOMElement;

class Result
{
    protected $code;

    protected $msg;

    protected $msgLang = 'en';

    protected $values = [];

    protected $extValues = [];

    public function __construct(DOMElement $node)
    {
        if ($node->hasAttribute('code')) {
            $this->code = (int) $node->getAttribute('code');
        }

        $this->parseResultNode($node);
    }

    public function success()
    {
        if ($this->code() >= 1000 && $this->code() < 2000) {
            return true;
        }

        return false;
    }

    public function code()
    {
        return $this->code;
    }

    public function message()
    {
        return $this->msg;
    }

    public function messageLanguage()
    {
        return $this->msgLang;
    }

    public function values()
    {
        return $this->values;
    }

    public function extValues()
    {
        return $this->extValues;
    }

    protected function parseResultNode($node)
    {
        foreach ($node->childNodes as $each) {
            if ($each->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            switch ($each->localName) {
                case 'msg':
                    $this->msg = $each->nodeValue;
                    if ($each->hasAttribute('lang')) {
                        $this->msgLang = $each->getAttribute('lang');
                    }
                    break;

                case 'value':
                    $this->values = array_merge_recursive($this->values, DOMTools::nodeToArray($each));
                    break;

                case 'extValue':
                    $this->extValues = array_merge_recursive($this->extValues, DOMTools::nodeToArray($each));
                    break;

                default:
                    break;
            }
        }
    }
}
