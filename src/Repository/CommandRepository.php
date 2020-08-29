<?php

namespace App\Repository;

use App\Entity\Buyer;
use App\Entity\Command;
use App\Entity\Customer;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    /**
     * Search the list of orders according to the buyer and the customer
     *
     * @param  Buyer $buyer
     * @param  Customer $customer
     * @return Command[]
    */
    public function findCommandForBuyerByCustomer(Buyer $buyer, Customer $customer)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.buyer = :buyer')
            ->andWhere('c.customer = :customer')
            ->setParameter('buyer', $buyer)
            ->setParameter('customer', $customer)
            ->getQuery()
            ->getResult()
        ;
    }
}
