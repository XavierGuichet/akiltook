<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\SportTeam;
use App\Entity\MediaObject;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\SportClubRepository")
 */
class SportClub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $Id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SportTeam", mappedBy="SportClub", orphanRemoval=true)
     */
    private $SportsTeams;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MediaObject", cascade={"persist", "remove"})
     */
    private $Logo;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|SportTeam[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addSportTeam(SportTeam $SportsTeam): self
    {
        if (!$this->SportsTeam->contains($SportsTeam)) {
            $this->SportsTeam[] = $SportsTeam;
            $SportsTeam->setClub($this);
        }

        return $this;
    }

    public function removeSportTeam(SportTeam $SportsTeam): self
    {
        if ($this->SportsTeam->contains($SportsTeam)) {
            $this->SportsTeam->removeElement($SportsTeam);
            // set the owning side to null (unless already changed)
            if ($SportsTeam->getClub() === $this) {
                $SportsTeam->setClub(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?MediaObject
    {
        return $this->Logo;
    }

    public function setLogo(?MediaObject $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }
}
