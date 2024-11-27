<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Classe::class, mappedBy: 'specialite', cascade: ['persist', 'remove'])]
    private Collection $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classes->contains($classe)) {
            $this->classes[] = $classe;
            $classe->setSpecialite($this);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        if ($this->classes->removeElement($classe)) {
            // Set the owning side to null (unless already changed)
            if ($classe->getSpecialite() === $this) {
                $classe->setSpecialite(null);
            }
        }

        return $this;
    }
}
