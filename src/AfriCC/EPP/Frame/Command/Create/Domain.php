<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Create_Domain extends Net_EPP_Frame_Command_Create
    {
        function __construct()
        {
            parent::__construct('domain');
        }

    }
