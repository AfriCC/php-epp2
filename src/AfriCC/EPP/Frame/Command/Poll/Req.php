<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Poll;

use AfriCC\EPP\Frame\Command\Poll;

class Req extends Poll
{
    public function __construct()
    {
        parent::__construct();
        $this->setOp('req');
    }

}
