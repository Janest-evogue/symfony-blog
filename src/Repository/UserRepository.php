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
class UserRepository extends ServiceEntityRepository
                     implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername($username)
    {
        // constructeur de requêtes (u est l'alias de user)
        $qb = $this->createQueryBuilder('u');
        
        // SELECT * FROM user u WHERE u.email = :username
        $qb
            ->where('u.email = :username')
            ->setParameter('username', $username)
        ;
        
        // retourne un objet User ou null
        return $qb->getQuery()->getOneOrNullResult();
    }

}
