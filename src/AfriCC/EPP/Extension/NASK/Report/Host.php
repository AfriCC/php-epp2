<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class Host extends Report
{
    /**
     * Construct Report Hosts frame. Sets report for reporting hosts
     */
    public function __construct()
    {
        $args = func_get_args();
        \call_user_func_array('parent::__construct', $args);
        $this->set('extreport:host');
    }

    /**
     * Set name of host to report. Do not use unless wanting report only about single host.
     *
     * @param string $name name of host to report
     */
    public function setName($name)
    {
        $this->set('extreport:host/extreport:name', $name);
    }
}
