<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Update_Domain extends Net_EPP_Frame_Command_Update
    {
        function __construct()
        {
            parent::__construct('domain');
        }
    }
