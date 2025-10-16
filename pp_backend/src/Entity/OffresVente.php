<?php

namespace App\Entity;

use App\Repository\OffresVenteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffresVenteRepository::class)]
#[ORM\Table(name: "offres_vente")]
class OffresVente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_offre = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_modification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOffre(): ?\DateTime
    {
        return $this->date_offre;
    }

    public function setDateOffre(\DateTime $date_offre): static
    {
        $this->date_offre = $date_offre;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateModification(): ?\DateTimeImmutable
    {
        return $this->date_modification;
    }

    public function setDateModification(\DateTimeImmutable $date_modification): static
    {
        $this->date_modification = $date_modification;

        return $this;
    }
}
