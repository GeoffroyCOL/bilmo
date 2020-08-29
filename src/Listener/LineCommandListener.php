<?php

namespace App\Listener;

use App\Entity\LineCommand;
use App\Service\PhoneHandler;
use App\Service\LineCommandHandler;

class LineCommandListener
{
    private $lineCommandHandler;
    private $phoneHandler;

    public function __construct(LineCommandHandler $lineCommandHandler, PhoneHandler $phoneHandler)
    {
        $this->lineCommandHandler = $lineCommandHandler;
        $this->phoneHandler = $phoneHandler;
    }
    
    /**
     * preRemove - Modifies the phone by removing the number order
     *
     * @param  LineCommand $lineCommand
     */
    public function preRemove(LineCommand $lineCommand)
    {
        $this->phoneHandler->edit($lineCommand->getPhone(), $lineCommand->getNumber(), -1);
    }
}
