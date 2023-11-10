<?php

namespace App\Entity;

use App\Entity\Participants;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TournoisRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TournoisRepository::class)]
#[Vich\Uploadable]
class Tournois
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $annee = null;

    #[Vich\UploadableField(mapping: 'imageWin', fileNameProperty: 'imageTrophee')]
    private ?File $imageFile = null;

    #[Vich\UploadableField(mapping: 'imageWinPart', fileNameProperty: 'imageWinner')]
    private ?File $imageFile1 = null;

    #[ORM\OneToMany(mappedBy: 'tournois', targetEntity: Classement::class)]
    private Collection $classements;

    #[ORM\ManyToMany(targetEntity: Sports::class, inversedBy: 'tournois' , cascade: ["persist"])]
    private Collection $sports;

    #[ORM\ManyToMany(targetEntity: Participants::class, inversedBy: 'tournois' , cascade: ["persist"])] 
    // cascade: ["persist, remove"] permet aussi d'enlever ceux en cascade en lien
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: 'tournois', targetEntity: Trophees::class)]
    private Collection $trophees;

    #[ORM\OneToMany(mappedBy: 'tournois', targetEntity: Photos::class)]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'tournois', targetEntity: Positions::class)]
    private Collection $positions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageTrophee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageWinner = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbParticipants = null;

   

    public function __construct()
    {
        
        $this->classements = new ArrayCollection();
        $this->sports = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->trophees = new ArrayCollection();
        $this->photos = new ArrayCollection();
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

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

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
            $classement->setTournois($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): self
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getTournois() === $this) {
                $classement->setTournois(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sports>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sports $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports->add($sport);
        }

        return $this;
    }

    public function removeSport(Sports $sport): self
    {
        $this->sports->removeElement($sport);

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
            $trophee->setTournois($this);
        }

        return $this;
    }

    public function removeTrophee(Trophees $trophee): self
    {
        if ($this->trophees->removeElement($trophee)) {
            // set the owning side to null (unless already changed)
            if ($trophee->getTournois() === $this) {
                $trophee->setTournois(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setTournois($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getTournois() === $this) {
                $photo->setTournois(null);
            }
        }

        return $this;
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
            $position->setTournois($this);
        }

        return $this;
    }

    public function removePosition(Positions $position): self
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getTournois() === $this) {
                $position->setTournois(null);
            }
        }

        return $this;
    }

    public function getImageTrophee(): ?string
    {
        return $this->imageTrophee;
    }

    public function setImageTrophee(?string $imageTrophee): self
    {
        $this->imageTrophee = $imageTrophee;

        return $this;
    }

    public function getImageWinner(): ?string
    {
        return $this->imageWinner;
    }

    public function setImageWinner(?string $imageWinner): self
    {
        $this->imageWinner = $imageWinner;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // if (null !== $imageFile) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     // $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile1(?File $imageFile1 = null): void
    {
        $this->imageFile = $imageFile1;

        // if (null !== $imageFile) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     // $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }

    public function setNbParticipants(?int $nbParticipants): self
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }




}
