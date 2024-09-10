<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Illustration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Illustration>
 */
class IllustrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Illustration::class);
    }

    //    /**
    //     * @return Illustrations[] Returns an array of Illustrations objects
    //     */
        public function findByIllustrationHome(): array
        {
           return $this->createQueryBuilder('i')
               ->orderBy('i.createdAt', 'DESC')
               ->setMaxResults(5)
               ->getQuery()
              ->getResult()
           ;
       }

    public function findAllDesc(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByCategory(Category $category)
    {
        return $this->createQueryBuilder('i')
            ->join('i.category', 'c')
            ->where('c.id = :categoryid')
            ->setParameter('categoryid', $category->getId())
            ->getQuery()
            ->getResult()
            ;

    }

    //    public function findOneBySomeField($value): ?Illustrations
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
