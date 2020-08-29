<?php

namespace App\Service;

use App\Entity\Buyer;
use App\Entity\Customer;
use App\Repository\BuyerRepository;
use Doctrine\ORM\EntityManagerInterface;

class BuyerHandler
{
    private $manager;
    private $repository;

    public function __construct(EntityManagerInterface $manager, BuyerRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }
    
    /**
     * removeRelationWithCustomer - Delete a relation between a buyer and a customer
     *
     * @param  Customer $customer
     * @param  Buyer $buyer
     * @return void
     */
    public function removeRelationWithCustomer(Customer $customer, Buyer $buyer)
    {
        $buyer->removeCustomer($customer);
        $this->manager->flush();
    }

    public function delete(Buyer $buyer)
    {
        $this->manager->remove($buyer);
        $this->manager->flush();
    }

    /**
     * getBuyerForCommand
     *
     * @param  int $id
     * @return Buyer|null
     */
    public function getBuyer(array $data): ?Buyer
    {
        return $this->repository->findOneBy($data);
    }
}
