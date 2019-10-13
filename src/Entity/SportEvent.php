<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Model\Event;
use App\Entity\SportTeam;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\SportEventRepository")
 * @ApiFilter(OrderFilter::class, properties={"id", "StartDate"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(DateFilter::class, properties={"StartDate"})
 */
class SportEvent extends Event
{
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

    public function getHomeTeam(): ?SportTeam
    {
        return $this->HomeTeam;
    }

    public function setHomeTeam(?SportTeam $HomeTeam): self
    {
        $this->HomeTeam = $HomeTeam;

        return $this;
    }

    public function getAwayTeam(): ?SportTeam
    {
        return $this->AwayTeam;
    }

    public function setAwayTeam(?SportTeam $AwayTeam): self
    {
        $this->AwayTeam = $AwayTeam;

        return $this;
    }
}
