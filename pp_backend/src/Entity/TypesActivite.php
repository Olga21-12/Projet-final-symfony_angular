<?php

namespace App\Entity;

use App\Repository\TypesActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesActiviteRepository::class)]
#[ORM\Table(name: "types_activite")]
class TypesActivite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_activite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeActivite(): ?string
    {
        return $this->type_activite;
    }

    public function setTypeActivite(string $type_activite): static
    {
        $this->type_activite = $type_activite;

        return $this;
    }
}
