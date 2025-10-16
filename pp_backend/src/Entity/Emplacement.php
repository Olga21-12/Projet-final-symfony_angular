<?php

namespace App\Entity;

use App\Repository\EmplacementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmplacementRepository::class)]
#[ORM\Table(name: "emplacements")]
class Emplacement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    /**
     * @var Collection<int, Bien>
     */
    #[ORM\OneToMany(targetEntity: Bien::class, mappedBy: 'emplacement')]
    private Collection $biens;

    /**
     * @var Collection<int, Recherche>
     */
    #[ORM\OneToMany(targetEntity: Recherche::class, mappedBy: 'emplacement')]
    private Collection $recherches;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'emplacement')]
    private Collection $users;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->recherches = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

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
            $bien->setEmplacement($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): static
    {
        if ($this->biens->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getEmplacement() === $this) {
                $bien->setEmplacement(null);
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
            $recherch->setEmplacement($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): static
    {
        if ($this->recherches->removeElement($recherch)) {
            // set the owning side to null (unless already changed)
            if ($recherch->getEmplacement() === $this) {
                $recherch->setEmplacement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setEmplacement($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEmplacement() === $this) {
                $user->setEmplacement(null);
            }
        }

        return $this;
    }
}
