<?php

namespace App\Repository;

use App\Entity\Took;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Took|null find($id, $lockMode = null, $lockVersion = null)
 * @method Took|null findOneBy(array $criteria, array $orderBy = null)
 * @method Took[]    findAll()
 * @method Took[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Took::class);
    }
}
