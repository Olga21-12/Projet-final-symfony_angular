<?php

namespace App\Entity;

use App\Repository\BienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Entity\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: BienRepository::class)]
#[ORM\Table(name: "biens")]
#[UniqueEntity(fields: ['adresse'], message: 'Ce bien existe déjà à cette adresse.')]
#[ORM\HasLifecycleCallbacks]
class Bien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 8)]
    #[Assert\Email()]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $surface = null;

    #[ORM\Column]
    private ?int $nombre_de_chambres = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    #[ORM\Column]
    private ?bool $luxe = null;

    use Timestampable;

    #[ORM\ManyToOne(inversedBy: 'biens')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'biens')]
    private ?Emplacement $emplacement = null;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'bien')]
    private Collection $photos;

    #[ORM\ManyToOne(inversedBy: 'biens')]
    private ?TypesDeBien $type = null;

    /**
     * @var Collection<int, Confort>
     */
    #[ORM\ManyToMany(targetEntity: Confort::class, inversedBy: 'biens')]
    private Collection $confort;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'bien')]
    private Collection $reservations;

    /**
     * @var Collection<int, OffresVente>
     */
    #[ORM\OneToMany(targetEntity: OffresVente::class, mappedBy: 'bien')]
    private Collection $offresVentes;

    #[ORM\ManyToOne(inversedBy: 'biens')]
    private ?TypesActivite $typeActivite = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->confort = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->offresVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNombreDeChambres(): ?int
    {
        return $this->nombre_de_chambres;
    }

    public function setNombreDeChambres(int $nombre_de_chambres): static
    {
        $this->nombre_de_chambres = $nombre_de_chambres;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function isLuxe(): ?bool
    {
        return $this->luxe;
    }

    public function setLuxe(bool $luxe): static
    {
        $this->luxe = $luxe;

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
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setBien($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getBien() === $this) {
                $photo->setBien(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypesDeBien
    {
        return $this->type;
    }

    public function setType(?TypesDeBien $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setBien($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getBien() === $this) {
                $reservation->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OffresVente>
     */
    public function getOffresVentes(): Collection
    {
        return $this->offresVentes;
    }

    public function addOffresVente(OffresVente $offresVente): static
    {
        if (!$this->offresVentes->contains($offresVente)) {
            $this->offresVentes->add($offresVente);
            $offresVente->setBien($this);
        }

        return $this;
    }

    public function removeOffresVente(OffresVente $offresVente): static
    {
        if ($this->offresVentes->removeElement($offresVente)) {
            // set the owning side to null (unless already changed)
            if ($offresVente->getBien() === $this) {
                $offresVente->setBien(null);
            }
        }

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

    public function __toString(): string
    {
        return $this->adresse ?? 'Bien #' . $this->id;
    }
}
