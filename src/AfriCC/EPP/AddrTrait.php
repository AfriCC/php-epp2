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
trait AddrTrait
{
    protected $host_attr_index = 0;

    protected function appendAddr($path, $ip)
    {
        // validate IP
        $ip_type = Validator::getIPType($ip);
        if ($ip_type === false) {
            throw new Exception(sprintf('%s is not a valid IP address', $ip));
        }

        $node = $this->set($path, $ip);

        if ($ip_type === Validator::TYPE_IPV4) {
            $node->setAttribute('ip', 'v4');
        } elseif ($ip_type === Validator::TYPE_IPV6) {
            $node->setAttribute('ip', 'v6');
        }
    }

    protected function appendHostAttr($base_path, $host, $ips = null)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        $base_path = sprintf($base_path, $this->host_attr_index);

        $this->set($base_path . '/domain:hostName', $host);

        if (!empty($ips) && is_array($ips)) {
            foreach ($ips as $ip) {
                $ip_type = Validator::getIPType($ip);
                if ($ip_type === false) {
                    throw new Exception(sprintf('%s is not a valid IP address', $ip));
                } elseif ($ip_type === Validator::TYPE_IPV4) {
                    $this->set($base_path . '/domain:hostAddr[@ip=\'v4\']', $ip);
                } elseif ($ip_type === Validator::TYPE_IPV6) {
                    $this->set($base_path . '/domain:hostAddr[@ip=\'v6\']', $ip);
                }
            }
        }

        ++$this->host_attr_index;
    }
}
