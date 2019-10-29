<?php

namespace AfriCC\EPP\Extension\NASK;

use AfriCC\EPP\Extension;
use AfriCC\EPP\ExtensionInterface;

class Report extends Extension implements ExtensionInterface
{
    protected $ignore_command = true;
    protected $command = 'report';
    protected $mapping = 'extreport';
    protected $extension = 'extreport';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extreport-2.0';

    public function setOffset($offset)
    {
        $this->set('extreport:offset', $offset);
    }

    public function setLimit($limit)
    {
        $this->set('extreport:limit', $limit);
    }
}
