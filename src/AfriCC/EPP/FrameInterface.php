<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

/**
 * every frame should at least provide the following signature to be able to
 * work with a client
 */
interface FrameInterface
{
    /**
     * Set value to path
     *
     * @param string $path
     * @param mixed $value
     *
     * @return \AfriCC\EPP\DOM\DOMElement
     */
    public function set($path, $value);

    /**
     * Get value from path
     *
     * @param string $query
     *
     * @return string|bool|\DOMNodeList
     */
    public function get($query);

    /**
     * @return string
     */
    public function __toString();
}
