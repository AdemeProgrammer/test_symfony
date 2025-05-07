<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prixBillet = null;

    #[ORM\ManyToOne(inversedBy: 'refReservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vol $refVol = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $ref_utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixBillet(): ?float
    {
        return $this->prixBillet;
    }

    public function setPrixBillet(float $prixBillet): static
    {
        $this->prixBillet = $prixBillet;

        return $this;
    }

    public function getRefVol(): ?Vol
    {
        return $this->refVol;
    }

    public function setRefVol(?Vol $refVol): static
    {
        $this->refVol = $refVol;

        return $this;
    }

    public function getRefUtilisateur(): ?Utilisateur
    {
        return $this->ref_utilisateur;
    }

    public function setRefUtilisateur(?Utilisateur $ref_utilisateur): static
    {
        $this->ref_utilisateur = $ref_utilisateur;

        return $this;
    }
}
