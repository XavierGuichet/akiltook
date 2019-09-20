<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Event;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\SportEventRepository")
 * @ApiFilter(OrderFilter::class, properties={"id", "startAt"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(DateFilter::class, properties={"startAt"})
 */
abstract class SportEvent extends Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $Id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam")
     * @ORM\JoinColumn(nullable=true)
     */
    private $HomeTeam;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportTeam")
     * @ORM\JoinColumn(nullable=true)
     */
    private $AwayTeam;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeam(): ?Team
    {
        return $this->HomeTeam;
    }

    public function setHomeTeam(?Team $HomeTeam): self
    {
        $this->HomeTeam = $HomeTeam;

        return $this;
    }

    public function getAwayTeam(): ?Team
    {
        return $this->AwayTeam;
    }

    public function setAwayTeam(?Team $AwayTeam): self
    {
        $this->AwayTeam = $AwayTeam;

        return $this;
    }
}
