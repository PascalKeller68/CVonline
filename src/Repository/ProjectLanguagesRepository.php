<?php

namespace App\Repository;

use App\Entity\ProjectLanguages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectLanguages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectLanguages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectLanguages[]    findAll()
 * @method ProjectLanguages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectLanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectLanguages::class);
    }

    // /**
    //  * @return ProjectLanguages[] Returns an array of ProjectLanguages objects
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
    public function findOneBySomeField($value): ?ProjectLanguages
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
