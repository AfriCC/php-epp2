<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\Rgp\Update;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Update\Domain as DomainUpdate;

/**
 * @see https://tools.ietf.org/html/rfc3915#section-4.2.5
 */
class Domain extends DomainUpdate implements Extension
{
    protected $extension = 'rgp';
    protected $extension_xmlns = 'urn:ietf:params:xml:ns:rgp-1.0';

    public function changeDomain($domain)
    {
        $this->setDomain($domain);
        $this->set('domain:chg');
    }

    public function addDomain($domain)
    {
        $this->setDomain($domain);
        $this->set('domain:add');
    }

    public function removeDomain($domain)
    {
        $this->setDomain($domain);
        $this->set('domain:rem');
    }

    public function restoreRequest()
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'request\']');
    }

    public function restoreReport()
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']');
    }

    public function setPreData($preData)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:preData', $preData);
    }

    public function setPostData($postData)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:postData', $postData);
    }

    public function setDelTime($delTime)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:delTime', $delTime);
    }

    public function setResTime($resTime)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:resTime', $resTime);
    }

    public function setResReason($resReason)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:resReason', $resReason);
    }

    public function addStatement($statement)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:statement[]', $statement);
    }

    public function setOther($other)
    {
        $this->set('//epp:epp/epp:command/epp:extension/rgp:update/rgp:restore[@op=\'report\']/rgp:report/rgp:other', $other);
    }
}
