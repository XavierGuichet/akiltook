<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ApiFilter(OrderFilter::class, properties={"id", "startAt"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(DateFilter::class, properties={"startAt"})
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $atHome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Team1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     */
    private $Team2;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Took", mappedBy="Event", orphanRemoval=true)
     */
    private $tooks;

    public function __construct()
    {
        $this->Title = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAtHome(): ?bool
    {
        return $this->atHome;
    }

    public function setAtHome(?bool $atHome): self
    {
        $this->atHome = $atHome;

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

    public function getTeam1(): ?Team
    {
        return $this->Team1;
    }

    public function setTeam1(?Team $Team1): self
    {
        $this->Team1 = $Team1;

        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->Team2;
    }

    public function setTeam2(?Team $Team2): self
    {
        $this->Team2 = $Team2;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return Collection|Took[]
     */
    public function getTooks(): Collection
    {
        return $this->tooks;
    }

    public function addTook(Took $took): self
    {
        if (!$this->tooks->contains($took)) {
            $this->tooks[] = $took;
            $took->setEvent($this);
        }

        return $this;
    }

    public function removeTitle(Took $took): self
    {
        if ($this->tooks->contains($took)) {
            $this->tooks->removeElement($took);
            // set the owning side to null (unless already changed)
            if ($took->getEvent() === $this) {
                $took->setEvent(null);
            }
        }

        return $this;
    }
}
