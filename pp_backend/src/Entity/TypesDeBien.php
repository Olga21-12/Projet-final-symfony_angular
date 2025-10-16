<?php

namespace App\Entity;

use App\Repository\TypesDeBienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesDeBienRepository::class)]
#[ORM\Table(name: "types_de_bien")]
class TypesDeBien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_de_bien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDeBien(): ?string
    {
        return $this->type_de_bien;
    }

    public function setTypeDeBien(string $type_de_bien): static
    {
        $this->type_de_bien = $type_de_bien;

        return $this;
    }
}
