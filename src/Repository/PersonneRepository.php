<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */

    public function findBytype()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.personneType = 1')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUtilisateur()
    {
        return $this->createQueryBuilder('p')
            ->where('p.personneType=1')
            ->getQuery()
            ->getResult();
    }
    public function getLastPanne()
    {
        return $this->createQueryBuilder('p')
                    ->select('MAX(p.id) as maxId')
                    ->getQuery()
                    ->getOneOrNullResult();

    }

    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getListePersonne()
    {
        $entityManager = $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT p, t
            FROM App\Entity\Personne p
            INNER JOIN p.personneType t'
        )->getArrayResult();
    }

    public function findTechnicien()
    {
        return $this->createQueryBuilder('p')
                    ->where('p.personneType=2')
                    ->getQuery()
                    ->getResult();
    }

}