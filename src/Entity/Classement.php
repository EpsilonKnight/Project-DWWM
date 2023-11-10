<?php

namespace App\Entity;

use App\Repository\ClassementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassementRepository::class)]
class Classement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $points = null;

    #[ORM\ManyToOne(inversedBy: 'classements')]
    private ?Participants $participants = null;

    #[ORM\ManyToOne(inversedBy: 'classements')]
    private ?Sports $sports = null;

    #[ORM\ManyToOne(inversedBy: 'classements')]
    private ?Tournois $tournois = null;

    #[ORM\Column(nullable: true)]
    private ?int $positions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(?float $points): self
    {
        $this->points = $points;

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

    public function getSports(): ?Sports
    {
        return $this->sports;
    }

    public function setSports(?Sports $sports): self
    {
        $this->sports = $sports;

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

    public function getPositions(): ?int
    {
        return $this->positions;
    }

    public function setPositions(?int $positions): self
    {
        $this->positions = $positions;

        return $this;
    }
}
