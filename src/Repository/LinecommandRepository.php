<?php

namespace App\Repository;

use App\Entity\Linecommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Linecommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Linecommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Linecommand[]    findAll()
 * @method Linecommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinecommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Linecommand::class);
    }

    // /**
    //  * @return Linecommand[] Returns an array of Linecommand objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Linecommand
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
