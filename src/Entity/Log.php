<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogRepository;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    // Relation vers User
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "logs")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Action effectuée
    #[ORM\Column(length: 255)]
    private ?string $action = null;

    // Date du log
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $date = null;

    // Détails supplémentaires (JSON ou texte)
    #[ORM\Column(type: "text", nullable: true)]
    private ?string $details = null;

    // ----- Getters / Setters -----
    public function getId(): ?int { return $this->id; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { $this->user = $user; return $this; }

    public function getAction(): ?string { return $this->action; }
    public function setAction(string $action): self { $this->action = $action; return $this; }

    public function getDate(): ?\DateTimeInterface { return $this->date; }
    public function setDate(\DateTimeInterface $date): self { $this->date = $date; return $this; }

    public function getDetails(): ?string { return $this->details; }
    public function setDetails(?string $details): self { $this->details = $details; return $this; }
}
