<?php
namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamenRepository::class)]
class Examen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'integer')]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToOne(targetEntity: Professor::class, inversedBy: 'exam', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professor $professeurDeGarde = null;

    #[ORM\ManyToMany(targetEntity: Classe::class)]
    private Collection $classes;

    #[ORM\ManyToMany(targetEntity: Exercice::class, inversedBy: 'examens')]
    #[ORM\JoinTable(name: 'examen_exercice')]
    private Collection $exercices;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->exercices = new ArrayCollection();
    }

    // Getters and Setters (no changes needed here for this part)

    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): void
    {
        $this->duration = $duration;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getProfesseurDeGarde(): ?Professor
    {
        return $this->professeurDeGarde;
    }

    public function setProfesseurDeGarde(?Professor $professeurDeGarde): void
    {
        $this->professeurDeGarde = $professeurDeGarde;
    }

    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function setClasses(Collection $classes): void
    {
        $this->classes = $classes;
    }

    public function removeExercice(Exercice $exercice): self
    {
        $this->exercices->removeElement($exercice);
        return $this;
    }
}
