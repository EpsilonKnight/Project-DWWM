<?php

namespace App\Entity;

use App\Repository\PositionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionsRepository::class)]
class Positions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $positions = null;

    #[ORM\ManyToOne(inversedBy: 'positions')]
    private ?Tournois $tournois = null;

    #[ORM\ManyToOne(inversedBy: 'positions')]
    private ?Participants $participants = null;


    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositions(): ?int
    {
        return $this->positions;
    }

    public function setPositions(?int $positions): self
    {
        $this->positions = $positions;

        return $this;
    }

    public function getTournois(): ?Tournois
    {
        return $this->tournois;
    }

    public function setTournois(?Tournois $tournois): self
    {
        $this->tournois = $tournois;

        return $this;
    }

    public function getParticipants(): ?Participants
    {
        return $this->participants;
    }

    public function setParticipants(?Participants $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

  
}
