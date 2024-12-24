<?php

namespace App\Repository;

use App\Entity\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Query>
 */
class QueryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Query::class);
    }

    public function findByTitleLike(string $title): array
    {
        $words = explode(' ', $title);

        $qb = $this->createQueryBuilder('p');

        foreach ($words as $index => $word) 
        {
            $qb->orWhere($qb->expr()->like('p.term', ':word' . $index))
               ->setParameter('word' . $index, '%' . $word . '%');
        }

        

        $query = $qb->getQuery();
        return $query->getResult();

        
        /*
        return $this->createQueryBuilder('p')
            ->where('p.term LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->getQuery()
            //->setMaxResults(1)
            ->getResult();
        */

    }

    //    /**
    //     * @return Query[] Returns an array of Query objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Query
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
