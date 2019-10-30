<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\Nominet\Release;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Update as UpdateCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see https://registrars.nominet.uk/namespace/uk/registration-and-domain-management/epp-commands#release
 */
class Domain extends UpdateCommand implements Extension
{
    protected $extension = 'r';
    protected $extension_xmlns = 'http://www.nominet.org.uk/epp/xml/std-release-1.0';

    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        $this->set('//epp:epp/epp:command/epp:update/r:release/r:domainName', $domain);
    }

    public function setRegistrarTag($tag)
    {
        $this->set('//epp:epp/epp:command/epp:update/r:release/r:registrarTag', $tag);
    }
}
