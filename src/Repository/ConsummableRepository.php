<?php

namespace App\Repository;

use App\Entity\Consummable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Took|null find($id, $lockMode = null, $lockVersion = null)
 * @method Took|null findOneBy(array $criteria, array $orderBy = null)
 * @method Took[]    findAll()
 * @method Took[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsummableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Consummable::class);
    }
}
