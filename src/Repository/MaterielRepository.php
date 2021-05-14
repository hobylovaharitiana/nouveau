<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    // /**
    //  * @return Materiel[] Returns an array of Materiel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Materiel
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getListeMateriel()
    {
        $entityManager = $this->getEntityManager();
        return $query = $entityManager->createQuery(
            'SELECT m, p
            FROM App\Entity\Materiel m
            INNER JOIN m.personne p'
        )->getArrayResult();
    }
    public function findMateriel()
    {
        return $this->createQueryBuilder('m')
            ->getQuery()
            ->getResult();
    }
    public function searchByName($keyword){
        $query = $this->createQueryBuilder('m')
            ->where('m.nomMateriel LIKE :key')->orWhere('m.marqueMateriel LIKE :key')
            ->setParameter('key', '%'.$keyword.'%')->getQuery();

        return $query->getResult();

    }

    public function findMerielByPersonne($id) {
        $query = $this->createQueryBuilder('m')
            ->where('m.personnes = :key')
            ->setParameter('key', $id)->getQuery();

        return $query->getResult();
    }
}
