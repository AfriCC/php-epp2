<?php

    /**
    * @package Net_EPP
    */
    class Net_EPP_Frame_Command_Delete_Contact extends Net_EPP_Frame_Command_Delete
    {
        function __construct()
        {
            parent::__construct('contact');
        }
    }
