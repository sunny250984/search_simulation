<?php

namespace App\Repository;

use App\Entity\Undefined;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Undefined>
 */
class UndefinedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Undefined::class);
    }

    public function findByTitleLike(string $title): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->getQuery()
            //->setMaxResults(1)
            ->getResult();
    }

    //    /**
    //     * @return Undefined[] Returns an array of Undefined objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Undefined
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
