<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

use Exception;

/**
 * a IP address trait to give common functionality needed to for addr elements
 */
trait PeriodTrait
{
    /**
     * Set value to path
     *
     * @param string $path
     * @param mixed $value
     *
     * @return \DOMElement
     */
    abstract public function set($path = null, $value = null);

    protected function appendPeriod($path, $period)
    {
        $matches = [];
        if (preg_match('/^(\d+)([a-z])$/i', $period, $matches)) {
            $this->set(sprintf($path, $matches[2]), $matches[1]);
        } else {
            throw new Exception(sprintf('%s is not a valid period', $period));
        }
    }
}
