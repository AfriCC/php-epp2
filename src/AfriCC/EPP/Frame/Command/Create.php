<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Create extends Net_EPP_Frame_Command
    {
        function __construct($type)
        {
            $this->type = $type;
            parent::__construct('create', $type);
        }
    }
