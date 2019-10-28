<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class Contact extends Report
{
    /**
     * Init Contacts Report frame
     */
    public function __construct()
    {
        //parent::__construct();
        $args = func_get_args();
        \call_user_func_array('parent::__construct', $args);
        $this->set('extreport:contact');
    }

    /**
     * Set ID of contact to generate report about
     *
     * Do not use this function if intended report is to be about all contact objects.
     *
     * @param string $contact ContactID of contact object to generate report about.
     */
    public function setContactId($contact)
    {
        $this->set('extreport:contact/extreport:conId', $contact);
    }
}
