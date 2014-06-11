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
    public function set($path, $value);

    public function get($query);

    public function __toString();
}
