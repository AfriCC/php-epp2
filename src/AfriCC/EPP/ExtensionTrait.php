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

trait ExtensionTrait
{
    protected $extension_xmlns;

    abstract protected function className($class);

    public function getExtensionName()
    {
        return strtolower($this->className(get_class($this)));
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}
