<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Julien Barbedette <barbedette.julien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\NICMX\Info;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Info;

/**
 * @see http://www.registry.mx
 */
class Rar extends Info implements Extension
{
    protected $extension_xmlns = 'http://www.nic.mx/rar-1.0';

    public function __construct()
    {
        parent::__construct();

        $this->set();
    }
}
