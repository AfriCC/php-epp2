<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Poll_Req extends Net_EPP_Frame_Command_Poll
    {
        function __construct()
        {
            parent::__construct();
            $this->setOp('req');
        }

    }
