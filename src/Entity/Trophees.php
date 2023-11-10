<?php

namespace App\Entity;

use App\Repository\TropheesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TropheesRepository::class)]
class Trophees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\ManyToOne(inversedBy: 'trophees')]
    private ?Tournois $tournois = null;

    #[ORM\ManyToMany(targetEntity: Participants::class, inversedBy: 'trophees')]
    private Collection $participants;

    #[ORM\ManyToOne(inversedBy: 'trophees')]
    private ?Sports $sports = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Participants $participant): self
    {
        $this->participants->removeElement($participant);

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
}
