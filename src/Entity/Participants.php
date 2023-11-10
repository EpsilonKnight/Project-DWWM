<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
#[Vich\Uploadable]
class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    

    #[ORM\OneToMany(mappedBy: 'participants', targetEntity: Classement::class)]
    private Collection $classements;

    #[ORM\ManyToMany(targetEntity: Tournois::class, mappedBy: 'participants')]
    private Collection $tournois;

    #[ORM\ManyToMany(targetEntity: Trophees::class, mappedBy: 'participants')]
    private Collection $trophees;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'participants', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\OneToMany(mappedBy: 'participants', targetEntity: Positions::class)]
    private Collection $positions;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    public function __construct()
    {
       
        $this->classements = new ArrayCollection();
        $this->tournois = new ArrayCollection();
        $this->trophees = new ArrayCollection();
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

   

    /**
     * @return Collection<int, Classement>
     */
    public function getClassements(): Collection
    {
        return $this->classements;
    }

    public function addClassement(Classement $classement): self
    {
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
            $classement->setParticipants($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): self
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getParticipants() === $this) {
                $classement->setParticipants(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournois>
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }

    public function addTournoi(Tournois $tournoi): self
    {
        if (!$this->tournois->contains($tournoi)) {
            $this->tournois->add($tournoi);
            $tournoi->addParticipant($this);
        }

        return $this;
    }

    public function removeTournoi(Tournois $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            $tournoi->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Trophees>
     */
    public function getTrophees(): Collection
    {
        return $this->trophees;
    }

    public function addTrophee(Trophees $trophee): self
    {
        if (!$this->trophees->contains($trophee)) {
            $this->trophees->add($trophee);
            $trophee->addParticipant($this);
        }

        return $this;
    }

    public function removeTrophee(Trophees $trophee): self
    {
        if ($this->trophees->removeElement($trophee)) {
            $trophee->removeParticipant($this);
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return Collection<int, Positions>
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Positions $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->setParticipants($this);
        }

        return $this;
    }

    public function removePosition(Positions $position): self
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getParticipants() === $this) {
                $position->setParticipants(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    
}
