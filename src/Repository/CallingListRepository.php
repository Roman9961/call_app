<?php

namespace App\Repository;

use App\Entity\CallingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CallingList|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallingList|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallingList[]    findAll()
 * @method CallingList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallingListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CallingList::class);
    }

    // /**
    //  * @return CallingList[] Returns an array of CallingList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CallingList
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
