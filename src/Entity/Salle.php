<?php

namespace App\Entity;

use ORM\GeneratedValue;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SalleRepository;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $code = null;

    #[ORM\Column(type: "integer")]
    private ?int $capacite = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et Setter pour le code
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    // Getter et Setter pour la capacité
    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;
        return $this;
    }

    // Getter et Setter pour le type
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
}
