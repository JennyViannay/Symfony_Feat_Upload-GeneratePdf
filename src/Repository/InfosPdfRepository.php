<?php

namespace App\Repository;

use App\Entity\InfosPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfosPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfosPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfosPdf[]    findAll()
 * @method InfosPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfosPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfosPdf::class);
    }

    // /**
    //  * @return InfosPdf[] Returns an array of InfosPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfosPdf
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
