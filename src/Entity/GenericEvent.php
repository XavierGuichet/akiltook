<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Model\Event;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FoodEventRepository")
 * @ApiFilter(OrderFilter::class, properties={"id", "startAt"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(DateFilter::class, properties={"startAt"})
 */
class GenericEvent extends Event
{
    public function __construct()
    {
    }
}