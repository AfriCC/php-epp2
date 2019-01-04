<?php

namespace AfriCC\EPP;

interface ClientInterface
{
    /**
     * Open a new connection to the EPP server
     *
     * @param bool|string $newPassword New password to set on longin, false if not changing pasword
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
}
