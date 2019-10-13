<?php

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
/*
 * @ApiFilter(OrderFilter::class, properties={"id", "StartDate"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(DateFilter::class, properties={"StartDate"})
*/
trait TimeBoundTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $StartDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $EndDate;

    public function __construct()
    {

    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(?\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
