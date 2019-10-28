<?php

namespace AfriCC\EPP;

/**
 * A client interface for implementing custom EPP clients
 *
 * In order to best use this interface, custom clients need to implement this
 * interface and be descendants of AbstractClient class
 *
 * @see http://tools.ietf.org/html/rfc5734
 * @see AbstractClient
 */
interface ClientInterface
{
    /**
     * Open a new connection to the EPP server
     *
     * @param bool|string $newPassword New password to set on login, false if not changing password
     */
    public function connect($newPassword = false);

    public function close();

    /**
     * request via EPP
     *
     * @param FrameInterface $frame Request frame to server
     *
     * @return string|\AfriCC\EPP\Frame\Response\MessageQueue|\AfriCC\EPP\Frame\Response Response from server
     */
    public function request(FrameInterface $frame);

    /**
     * Get client's ObjectSpec
     *
     * @return ObjectSpec
     */
    public function getObjectSpec();

    /**
     * Set client's ObjectSpec
     *
     * @param ObjectSpec $newObjectSpec
     */
    public function setObjectSpec(ObjectSpec $newObjectSpec);
}
