<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

     /**
      * @return User[] Returns an array of User objects
      */

    public function findByParent($value)
    {
        if(in_array('ROLE_ROOT', $value->getRoles())){
            $childrens = $this->createQueryBuilder('u')
                ->andWhere('u.roles not LIKE :val')
                ->setParameter('val', '%ROLE_ROOT%')
                ->getQuery()
                ->getResult();
        }else {
            $childrens = $this->createQueryBuilder('u')
                ->andWhere('u.parent = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getResult();

            if ($childrens) {
                foreach ($childrens as $children) {

                    $childrens = array_merge($childrens, $this->findByParent($children));
                }
            }
        }
        return $childrens;
    }


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :query')
            ->setParameter('query', $usernameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
