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

class DOMTools
{
    /**
     * transform epp style DOMElement to a php-array
     *
     * @param DOMElement $node
     * @param array $forceArrayKeys force certain tags into an array that are
     * expected to be iterated (forex: street).
     * @param array $ignoreAttributeKeys ignore certain attributes as they
     * contain duplicate information (forex: ipType).
     */
    public static function nodeToArray(
        PHP_DOMElement $node,
        $forceArrayKeys = ['hostAttr', 'hostObj', 'street', 'hostAddr'],
        $ignoreAttributeKeys = ['hostAddr']
    ) {
        $tmp = [];
        foreach ($node->childNodes as $each) {
            if ($each->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            // if node only has a type attribute lets distinguish them directly
            // and then ignore the attribtue
            if ($each->hasAttribute('type')) {
                $key = $each->localName . '@' . $each->getAttribute('type');
                $ignore_attributes = true;
            } else {
                $key = $each->localName;
                $ignore_attributes = false;
            }

            // in case of special keys, always create array
            if (in_array($key, $forceArrayKeys)) {
                $current = &$tmp[$key][];
                end($tmp[$key]);
                $insert_key = key($tmp[$key]);
            }
            // if key already exists, dynamically create an array
            elseif (isset($tmp[$key])) {
                if (!is_array($tmp[$key]) || !isset($tmp[$key][0])) {
                    $tmp[$key] = [$tmp[$key]];
                }
                $current = &$tmp[$key][];
                end($tmp[$key]);
                $insert_key = key($tmp[$key]);
            }
            // key was not yet set, so lets start off with a string
            else {
                $current = &$tmp[$key];
                $insert_key = null;
            }

            if ($each->hasChildNodes()) {
                $current = static::nodeToArray($each, $forceArrayKeys, $ignoreAttributeKeys);
            } else {
                $current = $each->nodeValue;

                if (!$ignore_attributes && !in_array($each->localName, $ignoreAttributeKeys) && $each->hasAttributes()) {
                    foreach ($each->attributes as $attr) {

                        // single attribute with empty node, use the attr-value directly
                        if ($each->localName === 'status' || ($each->attributes->length === 1 && $each->nodeValue === '')) {
                            $current = $attr->nodeValue;
                            break;
                        }

                        if ($insert_key) {
                            if (isset($tmp['@' . $key][$attr->nodeName]) && !is_array($tmp['@' . $key][$attr->nodeName])) {
                                $tmp['@' . $key][$attr->nodeName] = [$tmp['@' . $key][$attr->nodeName]];
                            }
                            $tmp['@' . $key][$attr->nodeName][$insert_key] = $attr->nodeValue;
                        } else {
                            $tmp['@' . $key][$attr->nodeName] = $attr->nodeValue;
                        }
                    }
                }
            }
        }

        return $tmp;
    }
}
