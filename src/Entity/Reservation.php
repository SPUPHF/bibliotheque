<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    // Relation vers User
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Relation vers Ouvrage
    #[ORM\ManyToOne(targetEntity: Ouvrage::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ouvrage $ouvrage = null;

    // Date de création de la réservation
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateCreation = null;

    // Booléen pour savoir si la réservation est active
    #[ORM\Column(type: "boolean")]
    private bool $active = true;

    // ----- Getters / Setters -----
    public function getId(): ?int { return $this->id; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }

    public function getOuvrage(): ?Ouvrage { return $this->ouvrage; }
    public function setOuvrage(?Ouvrage $ouvrage): self { $this->ouvrage = $ouvrage; return $this; }

    public function getDateCreation(): ?\DateTimeInterface { return $this->dateCreation; }
    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
