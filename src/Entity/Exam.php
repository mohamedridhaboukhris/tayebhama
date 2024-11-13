<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamRepository::class)]
class Exam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_remise = null;

    #[ORM\Column]
    private ?int $classe_concernee = null;

    
    #[ORM\Column(length: 255)]
    private ?string $professeurs = null;

    #[ORM\Column(length: 255)]
    private ?string $exercice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateRemise(): ?\DateTimeInterface
    {
        return $this->date_remise;
    }

    public function setDateRemise(\DateTimeInterface $date_remise): static
    {
        $this->date_remise = $date_remise;

        return $this;
    }

    public function getClasseConcernee(): ?int
    {
        return $this->classe_concernee;
    }

    public function setClasseConcernee(int $classe_concernee): static
    {
        $this->classe_concernee = $classe_concernee;

        return $this;
    }

    public function getProfesseurs(): ?string
    {
        return $this->professeurs;
    }

    public function setProfesseurs(string $professeurs): static
    {
        $this->professeurs = $professeurs;

        return $this;
    }

    public function getExercice(): ?string
    {
        return $this->exercice;
    }

    public function setExercice(string $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }
}
