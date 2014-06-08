<?php

    /**
    * @package Net_EPP
    */
    abstract class Net_EPP_Frame_Command_Poll extends Net_EPP_Frame_Command
    {
        function __construct()
        {
            parent::__construct('poll', '');
        }

        function setOp($op)
        {
            $this->command->setAttribute('op', $op);
        }

    }
