<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\DOM;

use DOMElement as PHP_DOMElement;
use DOMNodeList;

class DOMElement extends PHP_DOMElement
{
    public function hasChildNodes()
    {
        $children = $this->childNodes;
        if (!($children instanceof DOMNodeList) || $children->length === 0) {
            return false;
        }

        foreach ($children as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                return true;
            }
        }

        return false;
    }
}
