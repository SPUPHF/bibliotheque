<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

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
        $this->roles = ['ROLE_MEMBER']; // rôle par défaut
    }

    public function getId(): ?int { return $this->id; }

    // -------------------------------
    // IDENTIFICATION DE L'UTILISATEUR
    // -------------------------------
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // Compatibilité Symfony < 5.3 (optionnel mais utile)
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    // -------------------------------
    // EMAIL
    // -------------------------------
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    // -------------------------------
    // ROLES
    // -------------------------------
    public function getRoles(): array
    {
        // garantit qu’un rôle minimal existe toujours
        $roles = $this->roles;
        if (!in_array('ROLE_MEMBER', $roles)) {
            $roles[] = 'ROLE_MEMBER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    // -------------------------------
    // MOT DE PASSE
    // -------------------------------
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function eraseCredentials(): void
    {
        // Rien à nettoyer (utile si tu stockes des infos temporaires)
    }

    // -------------------------------
    // AUTRES CHAMPS
    // -------------------------------
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getDateInscription(): ?\DateTimeInterface { return $this->dateInscription; }
    public function setDateInscription(\DateTimeInterface $date): self { $this->dateInscription = $date; return $this; }

    // -------------------------------
    // RELATIONS : EMPRUNTS
    // -------------------------------
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

    // -------------------------------
    // RELATIONS : LOGS
    // -------------------------------
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
