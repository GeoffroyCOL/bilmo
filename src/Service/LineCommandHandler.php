<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Phone;
use App\Entity\LineCommand;
use App\Service\PhoneHandler;
use App\Repository\LineCommandRepository;

class LineCommandHandler
{
    private $phoneHandler;
    private $repository;

    public function __construct(PhoneHandler $phoneHandler, LineCommandRepository $repository)
    {
        $this->phoneHandler = $phoneHandler;
        $this->repository = $repository;
    }
    
    /**
     * editListPhones - Modifies the number of phones sold during an order
     *
     * @param  array $lineCommands
     */
    public function editListPhones(array $lineCommands)
    {
        foreach ($lineCommands as $lineCommand) {
            $this->phoneHandler->edit($lineCommand->getPhone(), $lineCommand->getNumber());
        }
    }
    
    /**
     * getLineCommandByAttributes
     *
     * @param  array $data
     * @return array
     */
    public function getLineCommandByAttributes(array $data): array
    {
        return $this->repository->findBy($data);
    }
    
    /**
     * getCommandsByPhones - Retrieves phone commands according to user
     *
     * @param  Phone $phone
     * @param  User $user
     * @return array
     */
    public function getCommandsByPhones(Phone $phone, User $user): array
    {
        $lineCommands = $this->getLineCommandByAttributes(['phone' => $phone]);
        $commands = [];

        foreach ($lineCommands as $line) {
            if ($user instanceof Admin || $user == $line->getCommand()->getCustomer()) {
                $command['number'] = $line->getNumber();
                $command['buyer'] = $line->getCommand()->getBuyer();

                //If the user is a admin, we get the customer
                if ($user instanceof Admin) {
                    $command['customer']  = $line->getCommand()->getCustomer();
                }

                $command['createdAt'] = $line->getCommand()->getCreatedAt();
                $command['priceCommand'] = $line->getCommand()->getPriceCommand();

                $commands[] = $command;
            }
        }

        return $commands;
    }
}
