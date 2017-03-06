<?php
namespace AfriCC\EPP\Extension\Ficora\Update;

use AfriCC\EPP\Frame\Command\Update\Domain;
use Exception;

/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 3/6/17
 * Time: 2:26 PM
 *
 * Registrant (ISP) may lock a domain so that
 * it cannot be updated in any other way than
 * by renewing it. The registry lock may also
 * be removed. Registrylock command allows the
 * following operation types: activate, deactivate, requestkey.
 *
 * - Activate sets the domain registry lock attribute. Activation requires 2-3 phone numbers in the request.
 *
 * <?xml version="1.0" encoding="UTF-8" standalone="no"?> <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
 * <command>
 * <update>
 * <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
 * <domain:name>example.fi</domain:name> <domain:chg>
 * <domain:registrylock type="activate"> <domain:smsnumber>+3584441111444</domain:smsnumber> <domain:smsnumber>+3584441111443</domain:smsnumber> <domain:smsnumber>+3584441111442</domain:smsnumber> <domain:numbertosend>1</domain:numbertosend> <domain:authkey>domainauthkey</domain:authkey>
 * </domain:registrylock>
 * </domain:chg>
 * </domain:update>
 * </update>
 * <clTRID>w0jii</clTRID>
 * </command>
 * </epp>
 */
class RegistryLock extends Domain
{
    protected $extension_xmlns = 'urn:ietf:params:xml:ns:domain-1.0';
    private $registry_lock_type = null;
    protected $registry_lock_change_types = [
        'activate',
        'deactivate',
        'requestkey',
    ];


    /**
     * @param $type
     * @throws Exception
     */
    public function setRegistryLockType($type)
    {
        if (!in_array($type, $this->registry_lock_change_types)) {
            throw new Exception(sprintf('%s is not a valid registrylock type .', $type));
        }

        $this->registry_lock_type = $type;
    }

    public function setRegistryLockPhones(array $phones)
    {
        if (!in_array($this->registry_lock_type, $this->registry_lock_change_types)) {
            throw new Exception(sprintf('%s is not a valid registrylock type .', $this->registry_lock_type));
        }

        foreach ($phones as $phone) {
            $this->set(
                '//epp:epp/epp:command/epp:update/domain:update/domain:chg/domain:registrylock[@type=\'' . $this->registry_lock_type . '\']/domain:smsnumber[]',
                $phone
            );
        }
    }

    public function setRegistryLockPhoneNumberToSend(int $sendToPhoneNumberReference)
    {
        if (!in_array($this->registry_lock_type, $this->registry_lock_change_types)) {
            throw new Exception(sprintf('%s is not a valid registrylock type .', $this->registry_lock_type));
        }

        $this->set(
            '//epp:epp/epp:command/epp:update/domain:update/domain:chg/domain:registrylock[@type=\'' . $this->registry_lock_type . '\']/domain:numbertosend[]',
            $sendToPhoneNumberReference
        );
    }

    public function setAuthKey($authKey)
    {
        $this->set(
            '//epp:epp/epp:command/epp:update/domain:update/domain:chg/domain:registrylock[@type=\'' . $this->registry_lock_type . '\']/domain:authkey',
            $authKey
        );
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}