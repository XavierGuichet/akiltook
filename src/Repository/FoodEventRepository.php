<?php

namespace App\Repository;

use App\Entity\FoodEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FoodEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodEvent[]    findAll()
 * @method FoodEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FoodEvent::class);
    }
}
