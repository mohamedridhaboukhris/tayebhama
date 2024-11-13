<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
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
    private ?string $EnseignantResponsable = null;

    #[ORM\Column(length: 255)]
    private ?string $classConcernee = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaires = null;

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

        return $this;
    }

    public function getEnseignantResponsable(): ?string
    {
        return $this->EnseignantResponsable;
    }

    public function setEnseignantResponsable(string $EnseignantResponsable): static
    {
        $this->EnseignantResponsable = $EnseignantResponsable;

        return $this;
    }

    public function getClassConcernee(): ?string
    {
        return $this->classConcernee;
    }

    public function setClassConcernee(string $classConcernee): static
    {
        $this->classConcernee = $classConcernee;

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
}
