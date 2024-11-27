<?php

namespace App\Entity;

use App\Repository\CoursRepository;
<<<<<<< HEAD
use Doctrine\DBAL\Types\Types;
=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
>>>>>>> origin/travailtayeb
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCours = null;

    #[ORM\Column(length: 255)]
<<<<<<< HEAD
    private ?string $EnseignantResponsable = null;
=======
    private ?string $enseignantResponsable = null;
>>>>>>> origin/travailtayeb

    #[ORM\Column(length: 255)]
    private ?string $classConcernee = null;

<<<<<<< HEAD
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaires = null;
=======
    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Chapitre::class, cascade: ['persist', 'remove'])]
    private Collection $chapitres;

    public function __construct()
    {
        $this->chapitres = new ArrayCollection();
    }
>>>>>>> origin/travailtayeb

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): static
    {
        $this->nomCours = $nomCours;
<<<<<<< HEAD

=======
>>>>>>> origin/travailtayeb
        return $this;
    }

    public function getEnseignantResponsable(): ?string
    {
<<<<<<< HEAD
        return $this->EnseignantResponsable;
    }

    public function setEnseignantResponsable(string $EnseignantResponsable): static
    {
        $this->EnseignantResponsable = $EnseignantResponsable;

=======
        return $this->enseignantResponsable;
    }

    public function setEnseignantResponsable(string $enseignantResponsable): static
    {
        $this->enseignantResponsable = $enseignantResponsable;
>>>>>>> origin/travailtayeb
        return $this;
    }

    public function getClassConcernee(): ?string
    {
        return $this->classConcernee;
    }

    public function setClassConcernee(string $classConcernee): static
    {
        $this->classConcernee = $classConcernee;
<<<<<<< HEAD

        return $this;
    }

    public function getHoraires(): ?\DateTimeInterface
    {
        return $this->horaires;
    }

    public function setHoraires(\DateTimeInterface $horaires): static
    {
        $this->horaires = $horaires;

        return $this;
    }
=======
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getChapitres(): Collection
    {
        return $this->chapitres;
    }

    public function addChapitre(Chapitre $chapitre): static
    {
        if (!$this->chapitres->contains($chapitre)) {
            $this->chapitres->add($chapitre);
            $chapitre->setCours($this);
        }
        return $this;
    }

    public function removeChapitre(Chapitre $chapitre): static
    {
        if ($this->chapitres->removeElement($chapitre)) {
            // set the owning side to null (unless already changed)
            if ($chapitre->getCours() === $this) {
                $chapitre->setCours(null);
            }
        }
        return $this;
    }

>>>>>>> origin/travailtayeb
}
