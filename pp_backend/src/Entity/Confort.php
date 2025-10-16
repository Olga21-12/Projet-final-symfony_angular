<?php

namespace App\Entity;

use App\Repository\ConfortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfortRepository::class)]
#[ORM\Table(name: "conforts")]
class Confort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Bien>
     */
    #[ORM\ManyToMany(targetEntity: Bien::class, mappedBy: 'confort')]
    private Collection $biens;

    /**
     * @var Collection<int, Recherche>
     */
    #[ORM\ManyToMany(targetEntity: Recherche::class, mappedBy: 'confort')]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $bien->addConfort($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): static
    {
        if ($this->biens->removeElement($bien)) {
            $bien->removeConfort($this);
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
            $recherch->addConfort($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): static
    {
        if ($this->recherches->removeElement($recherch)) {
            $recherch->removeConfort($this);
        }

        return $this;
    }
}
