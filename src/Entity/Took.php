<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TookRepository")
 */
class Took
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="tooks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $Event;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CreatedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DoneBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Game
    {
        return $this->Event;
    }

    public function setEvent(?Game $Event): self
    {
        $this->Event = $Event;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCreatedBy(): ?Account
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?Account $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    public function getDoneBy(): ?string
    {
        return $this->DoneBy;
    }

    public function setDoneBy(?string $DoneBy): self
    {
        $this->DoneBy = $DoneBy;

        return $this;
    }
}
