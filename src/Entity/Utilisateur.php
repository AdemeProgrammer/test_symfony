<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'refUtilisateurs')]
    private ?Modele $refModele = null;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'ref_pilote')]
    private Collection $vols;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'ref_id_pilote')]
    private Collection $pilote;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'ref_utilisateur')]
    private Collection $reservations;

    /**
     * @var Collection<int, Conges>
     */
    #[ORM\OneToMany(targetEntity: Conges::class, mappedBy: 'ref_pilote')]
    private Collection $conges;

    public function __construct()
    {
        $this->vols = new ArrayCollection();
        $this->pilote = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->conges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRefModele(): ?Modele
    {
        return $this->refModele;
    }

    public function setRefModele(?Modele $refModele): static
    {
        $this->refModele = $refModele;

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVols(): Collection
    {
        return $this->vols;
    }

    public function addVol(Vol $vol): static
    {
        if (!$this->vols->contains($vol)) {
            $this->vols->add($vol);
            $vol->setRefPilote($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getRefPilote() === $this) {
                $vol->setRefPilote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getPilote(): Collection
    {
        return $this->pilote;
    }

    public function addPilote(Vol $pilote): static
    {
        if (!$this->pilote->contains($pilote)) {
            $this->pilote->add($pilote);
            $pilote->setRefIdPilote($this);
        }

        return $this;
    }

    public function removePilote(Vol $pilote): static
    {
        if ($this->pilote->removeElement($pilote)) {
            // set the owning side to null (unless already changed)
            if ($pilote->getRefIdPilote() === $this) {
                $pilote->setRefIdPilote(null);
            }
        }

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
            $reservation->setRefUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRefUtilisateur() === $this) {
                $reservation->setRefUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conges>
     */
    public function getConges(): Collection
    {
        return $this->conges;
    }

    public function addConge(Conges $conge): static
    {
        if (!$this->conges->contains($conge)) {
            $this->conges->add($conge);
            $conge->setRefPilote($this);
        }

        return $this;
    }

    public function removeConge(Conges $conge): static
    {
        if ($this->conges->removeElement($conge)) {
            // set the owning side to null (unless already changed)
            if ($conge->getRefPilote() === $this) {
                $conge->setRefPilote(null);
            }
        }

        return $this;
    }
}
