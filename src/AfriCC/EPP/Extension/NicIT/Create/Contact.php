<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Riccardo Bessone <riccardo@bess.one>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\NicIT\Create;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Create\Contact as ContactCreate;
use AfriCC\EPP\Validator;
use Exception;

class Contact extends ContactCreate implements Extension
{
    protected $extension = 'extcon';
    protected $extension_xmlns = 'http://www.nic.it/ITNIC-EPP/extcon-1.0';

    protected static $entityTypes = [
        1, // Italian and foreign natural persons
        2, // Companies/one man companie
        3, // Freelance workers/professionals
        4, // Non-profit organizations
        5, // Public organizations
        6, // Other subjects
        7, // Foreigners who match 2-6
    ];

    public function setConsentForPublishing($consent = false)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:consentForPublishing', $consent ? 'true' : 'false');
    }

    public function setRegistrant($entityType, $nationalityCode = '', $regCode = '')
    {
        if (!in_array($entityType, self::$entityTypes)) {
            throw new Exception(sprintf('the entity type: \'%s\' is invalid', $entityType));
        }
        $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:registrant/extcon:entityType', $entityType);

        if ($nationalityCode != '' && !Validator::isCountryCode($nationalityCode)) {
            throw new Exception(sprintf('the country-code: \'%s\' is unknown', $nationalityCode));
        }
        $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:registrant/extcon:nationalityCode', $nationalityCode);

        if ($regCode != '') {
            $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:registrant/extcon:regCode', $regCode);
        }
    }
}
