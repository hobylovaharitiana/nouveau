<?php

namespace App\Repository;

use App\Entity\ProblemeMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProblemeMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProblemeMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProblemeMateriel[]    findAll()
 * @method ProblemeMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProblemeMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProblemeMateriel::class);
    }

    // /**
    //  * @return ProblemeMateriel[] Returns an array of ProblemeMateriel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProblemeMateriel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
