<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class Domain extends Report
{
    /**
     * Init Domains Report frame
     */
    public function __construct()
    {
        $args = func_get_args();
        \call_user_func_array('parent::__construct', $args);
        $this->set('extreport:domain');
    }

    /**
     * Set Domains state to report about
     *
     * Acceptable states are:
     * <ul>
     *     <li> STATE_REGISTERED</li>
     *     <li> STATE_EXPIRED</li>
     *     <li> STATE_BLOCKED</li>
     *     <li> STATE_RESERVED</li>
     *     <li> STATE_BOOK_BLOCKED</li>
     *     <li> STATE_DELETE_BLOCKED</li>
     * </ul>
     *
     * If not set default is assumed STATE_REGISTERED
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->set('extreport:domain/extreport:state', $state);
    }

    /**
     * Set expiry date of domain state.
     *
     * Do not use this if intended report is to be about all domains.
     *
     * @param string $date in proper format
     */
    public function setExDate($date)
    {
        $this->set('extreport:domain/extreport:exDate', $date);
    }

    /**
     * Add domain status to list of statuses of domains to include in report
     *
     * Depending on value of statusesIn, domains in report will either have or not have specified statuses.
     *
     * @see Domain::setStatusesIn()
     *
     * @param string $status domain status
     */
    public function addStatus($status)
    {
        $this->set('extreport:domain/extreport:statuses/extreport:status[]', $status);
    }

    /**
     * Set statutesIn attribute of statuses select.
     *
     * If set to true, report will include domains having specified statuses.
     * Otherwise report will include domains <b>not</b> having specified statuses.
     *
     * By default registrar assumes true for statusesIn
     *
     * @see Domain::addStatus();
     *
     * @param bool $statusesIn
     */
    public function setStatusesIn($statusesIn = true)
    {
        $node = $this->set('extreport:domain/extreport:statuses');

        $node->setAttribute('statusesIn', ($statusesIn) ? 'true' : 'false');
    }
}
