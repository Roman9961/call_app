<?php

namespace App\Repository;

use App\Entity\ClientMsisdn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientMsisdn|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientMsisdn|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientMsisdn[]    findAll()
 * @method ClientMsisdn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientMsisdnRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientMsisdn::class);
    }

    // /**
    //  * @return ClientMsisdn[] Returns an array of ClientMsisdn objects
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
    public function findOneBySomeField($value): ?ClientMsisdn
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
