<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\NICMX\Info;

use AfriCC\EPP\Frame\Command\Info as Info;
use AfriCC\EPP\ExtensionInterface as Extension;

/**
 * @link https://www.registry.net.za/content.php?wiki=1&contentid=18&title=EPP%20Contact%20Extensions
 */
class Rar extends Info implements Extension
{
    protected $extension_xmlns = 'http://www.nic.mx/rar-1.0';

    public function __construct()
    {
        parent::__construct();

        $this->set(null, '');
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}