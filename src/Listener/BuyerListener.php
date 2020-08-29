<?php

namespace App\Listener;

use App\Entity\Buyer;
use App\Entity\LineCommand;
use App\Service\PhoneHandler;
use App\Service\LineCommandHandler;

class BuyerListener
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
     * @param  Buyer $buyer
     */
    public function preRemove(Buyer $buyer)
    {
        foreach ($buyer->getCommands() as $lineCommand) {
            foreach ($lineCommand->getLineCommand()->toArray() as $line) {
                $this->phoneHandler->edit($line->getPhone(), $line->getNumber(), -1);
            }
        }
    }
}
