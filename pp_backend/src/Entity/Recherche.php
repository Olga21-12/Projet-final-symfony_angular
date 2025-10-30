<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\RechercheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RechercheRepository::class)]
#[ORM\Table(name: "recherches")]
#[ORM\HasLifecycleCallbacks]
class Recherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    use Timestampable;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bien:read'])]
    private ?string $mot_cle = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bien:read'])]
    private ?string $pays = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['bien:read'])]
    private ?float $budget_max = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['bien:read'])]
    private ?float $surface_max = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['bien:read'])]
    private ?int $nombre_de_chambres = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bien:read'])]
    private ?string $ville = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['bien:read'])]
    private ?string $type_bien = null;

    #[ORM\ManyToOne(inversedBy: 'recherches')]
    #[Groups(['bien:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'recherches')]
    #[ORM\JoinColumn(nullable: true)]
    //#[Groups(['bien:read'])]
    private ?Emplacement $emplacement = null;

    /**
     * @var Collection<int, TypesDeBien>
     */
    #[ORM\ManyToMany(targetEntity: TypesDeBien::class, inversedBy: 'recherches')]
  //  #[Groups(['bien:read'])]
    private Collection $typesDeBien;

    /**
     * @var Collection<int, Confort>
     */
    #[ORM\ManyToMany(targetEntity: Confort::class, inversedBy: 'recherches')]
   // #[Groups(['bien:read'])]
    private Collection $confort;

    #[ORM\ManyToOne(inversedBy: 'recherches')]
    #[ORM\JoinColumn(nullable: true)]
   // #[Groups(['bien:read'])]
    private ?TypesActivite $typeActivite = null;

    public function __construct()
    {
        $this->typesDeBien = new ArrayCollection();
        $this->confort = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection<int, TypesDeBien>
     */
    public function getTypesDeBien(): Collection
    {
        return $this->typesDeBien;
    }

    public function addTypesDeBien(TypesDeBien $typesDeBien): static
    {
        if (!$this->typesDeBien->contains($typesDeBien)) {
            $this->typesDeBien->add($typesDeBien);
        }

        return $this;
    }

    public function removeTypesDeBien(TypesDeBien $typesDeBien): static
    {
        $this->typesDeBien->removeElement($typesDeBien);

        return $this;
    }

    /**
     * @return Collection<int, Confort>
     */
    public function getConfort(): Collection
    {
        return $this->confort;
    }

    public function addConfort(Confort $confort): static
    {
        if (!$this->confort->contains($confort)) {
            $this->confort->add($confort);
        }

        return $this;
    }

    public function removeConfort(Confort $confort): static
    {
        $this->confort->removeElement($confort);

        return $this;
    }

    public function getTypeActivite(): ?TypesActivite
    {
        return $this->typeActivite;
    }

    public function setTypeActivite(?TypesActivite $typeActivite): static
    {
        $this->typeActivite = $typeActivite;

        return $this;
    }

    public function getPays(): ?string {
         return $this->pays; 
        }

    public function setPays(?string $pays): static {
         $this->pays = $pays; return $this; 
        }

    public function getTypeBien(): ?string {
         return $this->type_bien;
        }

    public function setTypeBien(?string $type_bien): static {
         $this->type_bien = $type_bien; 
         return $this; 
        }
}
