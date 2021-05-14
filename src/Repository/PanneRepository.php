<?php

namespace App\Repository;

use App\Entity\Panne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Panne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panne[]    findAll()
 * @method Panne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panne::class);
    }

    // /**
    //  * @return Panne[] Returns an array of Panne objects
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

    public function findOneBySomeField($value): ?Panne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function makaIdPanne()
    {
        return $this->createQueryBuilder('p')
                    ->select('MAX(p.id) as id')
                    ->getQuery()
                    ->getOneOrNullResult();
    }
    public function getListePanne()
    {
        $entityManager =  $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT p, m, prs
            FROM App\Entity\Panne p
            INNER JOIN p.materiel m
            INNER JOIN p.personnes prs '
        )->getArrayResult();
    }
    public function searchByName($keyword){
        $query = $this->createQueryBuilder('p')
            ->where('p.typePanne LIKE :key')
            ->setParameter('key', '%'.$keyword.'%')->getQuery();

        return $query->getResult();

    }
}
