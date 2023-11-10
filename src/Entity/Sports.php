<?php

namespace App\Entity;

use App\Entity\Commentaires;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SportsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: SportsRepository::class)]
#[Vich\Uploadable]
class Sports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

   

    #[ORM\OneToMany(mappedBy: 'sports', targetEntity: Classement::class)]
    private Collection $classements;

    #[ORM\ManyToMany(targetEntity: Tournois::class, mappedBy: 'sports')]
    private Collection $tournois;

    #[ORM\OneToMany(mappedBy: 'sports', targetEntity: Trophees::class)]
    private Collection $trophees;

    #[ORM\OneToMany(mappedBy: 'sports', targetEntity: Commentaires::class)]
    private Collection $commentaires;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'sports', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[Vich\UploadableField(mapping: 'imageTrophee', fileNameProperty: 'imageTrophee')]
    private ?File $imageFile1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageTrophee = null;


    public function __construct()
    {
       
        $this->classements = new ArrayCollection();
        $this->tournois = new ArrayCollection();
        $this->trophees = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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
            $classement->setSports($this);
        }

        return $this;
    }

    public function removeClassement(Classement $classement): self
    {
        if ($this->classements->removeElement($classement)) {
            // set the owning side to null (unless already changed)
            if ($classement->getSports() === $this) {
                $classement->setSports(null);
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
            $tournoi->addSport($this);
        }

        return $this;
    }

    public function removeTournoi(Tournois $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            $tournoi->removeSport($this);
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
            $trophee->setSports($this);
        }

        return $this;
    }

    public function removeTrophee(Trophees $trophee): self
    {
        if ($this->trophees->removeElement($trophee)) {
            // set the owning side to null (unless already changed)
            if ($trophee->getSports() === $this) {
                $trophee->setSports(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setSport($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getSport() === $this) {
                $commentaire->setSport(null);
            }
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

        // if (null !== $imageFile) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

    public function setImageFile1(?File $imageFile1 = null): void
    {
        $this->imageFile = $imageFile1;

        // if (null !== $imageFile) {
        //     // It is required that at least one field changes if you are using doctrine
        //     // otherwise the event listeners won't be called and the file is lost
        //     $this->updatedAt = new \DateTimeImmutable();
        // }
    }

    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    public function __toString() {
        return $this->nom; 
    }
}
