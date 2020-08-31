<?php

namespace App\Repository;

use App\Entity\LineCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineCommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineCommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineCommand[]    findAll()
 * @method LineCommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineCommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineCommand::class);
    }

    // /**
    //  * @return LineCommand[] Returns an array of LineCommand objects
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
    public function findOneBySomeField($value): ?LineCommand
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
