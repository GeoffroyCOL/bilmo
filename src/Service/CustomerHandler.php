<?php

namespace App\Service;

use App\Entity\Buyer;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomerHandler
{
    private $manager;
    private $encoder;
    private $repository;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, CustomerRepository $repository)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->repository = $repository;
    }
    
    /**
     * getCustomersByAttributes
     *
     * @param  array $data
     * @return array
     */
    public function getCustomersByAttributes(array $data): array
    {
        return $this->repository->findBy($data);
    }
    
    /**
     * AddRelationWithBuyer - Add a relation between a buyer and a customer after a command
     *
     * @param  Customer $customer
     * @param  Buyer $buyer
     */
    public function addRelationWithBuyer(Customer $customer, Buyer $buyer)
    {
        $customer->addBuyer($buyer);
        $this->manager->flush();
    }
}
