<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Poll_Ack extends Net_EPP_Frame_Command_Poll
    {
        function __construct()
        {
            parent::__construct();
            $this->setOp('ack');
        }

        function setMsgID($id)
        {
            $this->command->setAttribute('msgID', $id);
        }

    }
