<?php

namespace App\Entity;

use App\Repository\TypesDeBienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypesDeBienRepository::class)]
#[ORM\Table(name: "types_de_bien")]
class TypesDeBien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bien:read'])]
    private ?string $type_de_bien = null;

    /**
     * @var Collection<int, Bien>
     */
    #[ORM\OneToMany(targetEntity: Bien::class, mappedBy: 'type')]
    private Collection $biens;

    /**
     * @var Collection<int, Recherche>
     */
    #[ORM\ManyToMany(targetEntity: Recherche::class, mappedBy: 'typesDeBien')]
    private Collection $recherches;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->recherches = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Bien>
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(Bien $bien): static
    {
        if (!$this->biens->contains($bien)) {
            $this->biens->add($bien);
            $bien->setType($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): static
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getType() === $this) {
                $bien->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherch(Recherche $recherch): static
    {
        if (!$this->recherches->contains($recherch)) {
            $this->recherches->add($recherch);
            $recherch->addTypesDeBien($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): static
    {
        if ($this->recherches->removeElement($recherch)) {
            $recherch->removeTypesDeBien($this);
        }

        return $this;
    }
}
