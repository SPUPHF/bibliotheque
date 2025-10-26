<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class User
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateInscription = null;

    // Relation vers Emprunt
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Emprunt::class)]
    private Collection $emprunts;

    // Relation vers Log
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Log::class)]
    private Collection $logs;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    // ----- Getters / Setters -----
    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getRoles(): array { return $this->roles; }
    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getDateInscription(): ?\DateTimeInterface { return $this->dateInscription; }
    public function setDateInscription(\DateTimeInterface $date): self { $this->dateInscription = $date; return $this; }

    // ----- Emprunts -----
    public function getEmprunts(): Collection { return $this->emprunts; }
    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts[] = $emprunt;
            $emprunt->setUser($this);
        }
        return $this;
    }
    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            if ($emprunt->getUser() === $this) {
                $emprunt->setUser(null);
            }
        }
        return $this;
    }

    // ----- Logs -----
    public function getLogs(): Collection { return $this->logs; }
    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setUser($this);
        }
        return $this;
    }
    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }
        return $this;
    }
}
