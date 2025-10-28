<?php

namespace App\Entity;

use App\Repository\OffresVenteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OffresVenteRepository::class)]
#[ORM\Table(name: "offres_vente")]
class OffresVente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bien:read'])]
    private ?string $statut = null;

    use Timestampable;
    
    #[ORM\ManyToOne(inversedBy: 'offresVentes')]
  //  #[Groups(['bien:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'offresVentes')]
  //  #[Groups(['bien:read'])]
    private ?Bien $bien = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): static
    {
        $this->bien = $bien;

        return $this;
    }
}
