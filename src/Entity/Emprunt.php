<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EmpruntRepository;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    // Relation vers User
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "emprunts")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Relation vers Exemplaire
    #[ORM\ManyToOne(targetEntity: Exemplaire::class, inversedBy: "emprunts")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exemplaire $exemplaire = null;


    // Date de début d'emprunt
    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateEmprunt = null;

    // Date de retour prévue
    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateRetourPrevu = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateDuRetour = null;

    // Montant de pénalité si retard
    #[ORM\Column(type: "float", nullable: true)]
    private ?float $penalite = null;

    // ----- Getters et Setters -----

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): self
    {
        $this->exemplaire = $exemplaire;
        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): self
    {
        $this->dateEmprunt = $dateEmprunt;
        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): self
    {
        $this->dateRetour = $dateRetour;
        return $this;
    }

    public function getPenalite(): ?float
    {
        return $this->penalite;
    }

    public function setPenalite(?float $penalite): self
    {
        $this->penalite = $penalite;
        return $this;
    }
}
