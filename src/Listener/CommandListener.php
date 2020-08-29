<?php

namespace App\Listener;

use App\Entity\Command;
use App\Service\PhoneHandler;
use App\Service\CustomerHandler;

class CommandListener
{
    private $customerHandler;
    private $phoneHandler;

    public function __construct(CustomerHandler $customerHandler, PhoneHandler $phoneHandler)
    {
        $this->customerHandler = $customerHandler;
        $this->phoneHandler = $phoneHandler;
    }
    
    /**
     * postPersist - Add a relation between a customer and buyer before a command
     *
     * @param  Command $command
     */
    public function postPersist(Command $command)
    {
        $this->customerHandler->AddRelationWithBuyer($command->getCustomer(), $command->getBuyer());

        //Allows you to modify the numberSold and active attributes
        /*foreach ($command->getLineCommand()->toArray() as $line) {
            $this->phoneHandler->edit($line->getPhone(), $line->getNumber());
        }*/
    }
}
