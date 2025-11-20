<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\OuvrageRepository;

#[ORM\Entity(repositoryClass: OuvrageRepository::class)]
class Ouvrage
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    // Titre de l'ouvrage
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    // Auteur
    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    public function getAuteur(): ?string { return $this->auteur; }
    public function setAuteur(?string $auteur): self { $this->auteur = $auteur; return $this; }

    // L'editeur de l'ouvrage
    #[ORM\Column(length: 100)]
    private ?string $editeur = null;

    // Identifiant ISBN
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $isbn = null;

    // La ou les categories
    #[ORM\Column(type: "json", nullable: true)]
    private array $categories = [];

    // Tags pour mieux retrouver/associer l'ouvrage à une requete
    #[ORM\Column(type: "json", nullable: true)]
    private array $tags = [];

    // La langue de l'ouvrage
    #[ORM\Column(length: 50)]
    private ?string $langue = null;

    // Annee de publication
    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $annee = null;

    // Resume du livre
    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $resume = null;

    // Relation vers Exemplaire
    #[ORM\OneToMany(mappedBy: "ouvrage", targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    // Relation vers Reservation
    #[ORM\OneToMany(mappedBy: "ouvrage", targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->exemplaires = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    // ----- Getters / Setters -----
    public function getId(): ?int { return $this->id; }

    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(string $titre): self { $this->titre = $titre; return $this; }

    public function getEditeur(): ?string { return $this->editeur; }
    public function setEditeur(?string $editeur): self { $this->editeur = $editeur; return $this; }

    public function getIsbn(): ?string { return $this->isbn; }
    public function setIsbn(?string $isbn): self { $this->isbn = $isbn; return $this; }

    public function getCategories(): array { return $this->categories; }
    public function setCategories(array $categories): self { $this->categories = $categories; return $this; }

    public function getTags(): array { return $this->tags; }
    public function setTags(array $tags): self { $this->tags = $tags; return $this; }

    public function getLangue(): ?string { return $this->langue; }
    public function setLangue(string $langue): self { $this->langue = $langue; return $this; }

    public function getAnnee(): ?int { return $this->annee; }
    public function setAnnee(?int $annee): self { $this->annee = $annee; return $this; }

    public function getResume(): ?string { return $this->resume; }
    public function setResume(?string $resume): self { $this->resume = $resume; return $this; }

    // ----- Exemplaires -----
    public function getExemplaires(): Collection { return $this->exemplaires; }
    public function addExemplaire(Exemplaire $exemplaire): self
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires[] = $exemplaire;
            $exemplaire->setOuvrage($this);
        }
        return $this;
    }
    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            if ($exemplaire->getOuvrage() === $this) {
                $exemplaire->setOuvrage(null);
            }
        }
        return $this;
    }

    // ----- Reservations -----
    public function getReservations(): Collection { return $this->reservations; }
    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setOuvrage($this);
        }
        return $this;
    }
    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getOuvrage() === $this) {
                $reservation->setOuvrage(null);
            }
        }
        return $this;
    }
}
