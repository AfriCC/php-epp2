<?php
namespace AfriCC\EPP\Extension\Ficora\Renew;

use AfriCC\EPP\Frame\Command\Renew\Domain;

/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 3/6/17
 * Time: 12:36 PM
 */
class Autorenew extends Domain
{
    protected $extension_xmlns = 'urn:ietf:params:xml:ns:domain-1.0';

    /**
     * @param string $domainName
     * @param int $action
     *
     * Auto renew is an extension for the <domain:renew> message. In the extension, the request may be given a <domain:autorenew> element with values 0 or 1. Value 1 sets the auto renewal process on to the specific domain name and removes the auto renewal process. Automatic renewal renews a domain name 30 days before expiration. Before renewing, the ISP will be messaged a Poll message that the renewing will happen in x days.
     * Marking a domain for delete will cancel auto renew operations.
     * Domain info returns will tell if auto renew is set and when the next auto renew
     * operation will occur.
     * If a domain name is transferred to another ISP, auto renew will be canceled.
     * Auto renew example request:
     *
     * <?xml version="1.0" encoding="UTF-8" standalone="no"?> <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
     * <command>
     * <renew>
     * <domain:autorenew xmlns:domain="urn:ietf:params:xml:ns:domain-
     * 1.0">
     * <domain:name>example.fi</domain:name> <domain:value>1</domain:value>
     * </domain:autorenew>
     * </renew>
     * <clTRID>ABC-12345</clTRID>
     * </command>
     * </epp>
     */
    public function autoRenew(string $domainName, int $action)
    {
        $this->set("//epp:epp/epp:command/epp:renew/domain:autorenew/domain:name", $domainName);
        $this->set("//epp:epp/epp:command/epp:renew/domain:autorenew/domain:value", $action);
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}