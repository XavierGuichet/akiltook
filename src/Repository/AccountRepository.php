<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function loadUserByEmailOrUsername($emailOrUsername)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $emailOrUsername)
            ->setParameter('email', $emailOrUsername)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByOAuth($property, $oauthId)
    {
        return $this->createQueryBuilder('u')
            ->where('u.' . $property . ' = :oauthId')
            ->setParameter('oauthId', $oauthId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
