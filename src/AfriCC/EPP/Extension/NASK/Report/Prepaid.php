<?php

namespace AfriCC\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\Report;

class Prepaid extends Report
{
    /**
     * Check whether account type is acceptable by NASK
     *
     * @param string $accountType
     *
     * @return bool
     */
    private function isAccountType($accountType)
    {
        switch (strtoupper($accountType)) {
            case 'DOMAIN':
            case 'ENUM':
                return true;
            default:
                return false;
        }
    }

    /**
     * Set account type in conjunction with payments report.
     *
     * Use either this or setFundsAccountType. Never combine them in single frame.
     *
     * Acceptable accountType:
     * <ul>
     *  <li>DOMAIN</li>
     *  <li>ENUM</li>
     * </ul>
     *
     * @see Prepaid::setFundsAccountType()
     *
     * @uses Prepaid::isAccountType()
     *
     * @param string $accountType
     *
     * @throws \Exception On wrong account type
     */
    public function setPaymentsAccountType($accountType)
    {
        if (!$this->isAccountType($accountType)) {
            throw new \Exception(sprintf('"%s" is not valid Account Type!', $accountType));
        }
        $this->set('extreport:prepaid/extreport:payment/extreport:accountType', $accountType);
    }

    /**
     * Set account type in conjunction with payments report.
     *
     * Use either this or setPaymentsAccountType. Never combine them in single frame.
     *
     * Acceptable accountType:
     * <ul>
     *  <li>DOMAIN</li>
     *  <li>ENUM</li>
     * </ul>
     *
     * @see Prepaid::setPaymentsAccountType()
     *
     * @uses Prepaid::isAccountType()
     *
     * @param string $accountType
     *
     * @throws \Exception On wrong account type
     */
    public function setFundsAccountType($accountType)
    {
        if (!$this->isAccountType($accountType)) {
            throw new \Exception(sprintf('"%s" is not valid Account Type!', $accountType));
        }
        $this->set('extreport:prepaid/extreport:paymentFunds/extreport:accountType', $accountType);
    }
}
