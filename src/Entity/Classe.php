<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 10)]
    private ?string $niveau = null;

    #[ORM\ManyToOne(targetEntity: Specialite::class, inversedBy: 'classes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Specialite $specialite = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\Range(
        min: 2010,
        max: 2030,
        notInRangeMessage: "L'année doit être entre 2010 et 2030"
    )]
    private ?int $annee = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min: 25,
        max: 32,
        notInRangeMessage: 'Le nombre d\'étudiants doit être entre {{ min }} et {{ max }}.'
    )]
    private ?int $nombreEtudiants = null;

    #[ORM\OneToMany(targetEntity: Etudiant::class, mappedBy: 'classe', cascade: ['persist', 'remove'])]
    private Collection $etudiants;

    #[ORM\Column(type: 'string', length: 20, options: ['default' => 'cours'])]
    private ?string $status = 'cours'; // Valeur par défaut : "cours"

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;
        return $this;
    }

    public function getNombreEtudiants(): ?int
    {
        return $this->nombreEtudiants;
    }

    public function setNombreEtudiants(int $nombreEtudiants): self
    {
        $this->nombreEtudiants = $nombreEtudiants;
        return $this;
    }

    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setClasse($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            if ($etudiant->getClasse() === $this) {
                $etudiant->setClasse(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status ?? 'cours';
        return $this;
    }
}
