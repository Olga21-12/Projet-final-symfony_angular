<?php

namespace App\Entity;

use App\Repository\RechercheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RechercheRepository::class)]
#[ORM\Table(name: "recherches")]
class Recherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $mot_cle = null;

    #[ORM\Column(nullable: true)]
    private ?float $budget_max = null;

    #[ORM\Column(nullable: true)]
    private ?float $surface_max = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_de_chambres = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMotCle(): ?string
    {
        return $this->mot_cle;
    }

    public function setMotCle(string $mot_cle): static
    {
        $this->mot_cle = $mot_cle;

        return $this;
    }

    public function getBudgetMax(): ?float
    {
        return $this->budget_max;
    }

    public function setBudgetMax(?float $budget_max): static
    {
        $this->budget_max = $budget_max;

        return $this;
    }

    public function getSurfaceMax(): ?float
    {
        return $this->surface_max;
    }

    public function setSurfaceMax(?float $surface_max): static
    {
        $this->surface_max = $surface_max;

        return $this;
    }

    public function getNombreDeChambres(): ?int
    {
        return $this->nombre_de_chambres;
    }

    public function setNombreDeChambres(?int $nombre_de_chambres): static
    {
        $this->nombre_de_chambres = $nombre_de_chambres;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
}
