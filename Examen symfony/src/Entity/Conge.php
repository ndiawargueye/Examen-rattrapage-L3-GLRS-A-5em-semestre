<?php
namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CongeRepository::class)]
#[ORM\Table(name: 'conge')]
class Conge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // Types : ANNUEL, MALADIE, MATERNITE, SANS_SOLDE
    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Choice(choices: ['ANNUEL', 'MALADIE', 'MATERNITE', 'SANS_SOLDE'])]
    private string $typeConge;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dateFin;

    // Statuts : EN_ATTENTE, APPROUVE, REFUSE
    #[ORM\Column(type: 'string', length: 15)]
    #[Assert\Choice(choices: ['EN_ATTENTE', 'APPROUVE', 'REFUSE'])]
    private string $statut = 'EN_ATTENTE';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $motif = null;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'conges')]
    #[ORM\JoinColumn(nullable: false)]
    private Employe $employe;

    public function getId(): ?int { return $this->id; }
    public function getTypeConge(): string { return $this->typeConge; }
    public function setTypeConge(string $t): self { $this->typeConge = $t; return $this; }
    public function getDateDebut(): \DateTimeInterface { return $this->dateDebut; }
    public function setDateDebut(\DateTimeInterface $d): self { $this->dateDebut = $d; return $this; }
    public function getDateFin(): \DateTimeInterface { return $this->dateFin; }
    public function setDateFin(\DateTimeInterface $d): self { $this->dateFin = $d; return $this; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $s): self { $this->statut = $s; return $this; }
    public function getMotif(): ?string { return $this->motif; }
    public function setMotif(?string $m): self { $this->motif = $m; return $this; }
    public function getEmploye(): Employe { return $this->employe; }
    public function setEmploye(Employe $e): self { $this->employe = $e; return $this; }

    // Calcul du nombre de jours
    public function getNbJours(): int
    {
        return $this->dateDebut->diff($this->dateFin)->days;
    }
}
