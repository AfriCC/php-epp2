<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class Future extends Report
{
    /**
     * Init Futures report frame
     */
    public function __construct()
    {
        $args = func_get_args();
        \call_user_func_array('parent::__construct', $args);
        $this->set('extreport:future');
    }

    /**
     * Set expiry date of Future elements to report about
     *
     * Do not use this function if intended report is to be about all Future objects.
     *
     * @param string $exDate Expiry date of future in proper format
     */
    public function setExDate($exDate)
    {
        $this->set('extreport:future/extreport:exDate', $exDate);
    }
}
