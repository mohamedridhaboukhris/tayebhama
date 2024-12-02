<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image_exercice = null; // New image_exercice field

    #[ORM\ManyToMany(targetEntity: Examen::class, mappedBy: 'exercices')]
    private Collection $examens;

    public function __construct()
    {
        $this->examens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getImageExercice(): ?string
    {
        return $this->image_exercice;
    }

    public function setImageExercice(?string $image_exercice): void
    {
        $this->image_exercice = $image_exercice;
    }

    public function getExamens(): Collection
    {
        return $this->examens;
    }

    public function addExamen(Examen $examen): self
    {
        if (!$this->examens->contains($examen)) {
            $this->examens[] = $examen;
        }
        return $this;
    }

    public function removeExamen(Examen $examen): self
    {
        $this->examens->removeElement($examen);
        return $this;
    }
}

