<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Buyer;
use App\Entity\Command;
use App\Entity\Customer;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandHandler
{
    private $manager;
    private $repository;
    private $security;

    public function __construct(EntityManagerInterface $manager, CommandRepository $repository, Security $security)
    {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->security = $security;
    }
    
    /**
     * add
     *
     * @param  Command $command
     * @return Command
     */
    public function add(Command $command): Command
    {
        $command->setCustomer($this->security->getUser());
        $this->manager->persist($command);
        $this->manager->flush();

        return $command;
    }
    
    /**
     * delete
     *
     * @param  Command $command
     */
    public function delete(Command $command)
    {
        $this->manager->remove($command);
        $this->manager->flush();
    }

    /**
     * getCommandsByAttributes - Displays the list of commands from buyers placed with a client
     *
     * @param  Buyer $buyer
     * @param  Customer $customer
     * @return Command[]
     */
    public function getCommandForBuyerByCustomer(Buyer $buyer, Customer $customer): array
    {
        return $this->repository->findCommandForBuyerByCustomer($buyer, $customer);
    }
    
    /**
     * getCommandsByAttribute
     *
     * @param  array $data
     * @return  array
     */
    public function getCommandsByAttribute(array $data): array
    {
        return $this->repository->findBy($data);
    }
    
    /**
     * AddCommandByBuyer - Add the list of orders placed by a buyer according to the role of the user who requests it
     *
     * @param  mixed $data
     * @param  User $user
     * @return void
     */
    public function AddCommandByBuyer(array $data, User $user)
    {
        //All commands
        if ($user instanceof Admin) {
            foreach ($data as $buyer) {
                $buyer->setCommands($this->getCommandsByAttribute(['buyer' => $buyer]));
            }
        }

        //Commands ordered with the customer
        if ($user instanceof Customer) {
            foreach ($data as $buyer) {
                $buyer->setCommands($this->getCommandForBuyerByCustomer($buyer, $user));
            }
        }
    }
}
