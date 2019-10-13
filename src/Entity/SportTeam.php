<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\SportClub;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\SportTeamRepository")
 */
class SportTeam
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
     * @ORM\ManyToOne(targetEntity="SportClub", inversedBy="SportsTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $SportClub;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getSportClub(): ?SportClub
    {
        return $this->SportClub;
    }

    public function setSportClub(SportClub $SportClub): self
    {
        $this->SportClub = $SportClub;

        return $this;
    }
}
