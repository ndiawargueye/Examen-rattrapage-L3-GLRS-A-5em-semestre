<?php
namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
#[ORM\Table(name: 'contrat')]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // Types possibles : CDI, CDD, STAGE
    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Choice(choices: ['CDI', 'CDD', 'STAGE'])]
    private string $typeContrat;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    private \DateTimeInterface $dateDebut;

    // Nullable pour CDI
    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive]
    private float $salaireBase;

    #[ORM\Column(type: 'boolean')]
    private bool $periodeEssai = false;

    // true = contrat toujours actif
    #[ORM\Column(type: 'boolean')]
    private bool $actif = true;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private Employe $employe;

    #[ORM\ManyToOne(targetEntity: Poste::class)]
    private ?Poste $poste = null;

    public function getId(): ?int { return $this->id; }
    public function getTypeContrat(): string { return $this->typeContrat; }
    public function setTypeContrat(string $t): self { $this->typeContrat = $t; return $this; }
    public function getDateDebut(): \DateTimeInterface { return $this->dateDebut; }
    public function setDateDebut(\DateTimeInterface $d): self { $this->dateDebut = $d; return $this; }
    public function getDateFin(): ?\DateTimeInterface { return $this->dateFin; }
    public function setDateFin(?\DateTimeInterface $d): self { $this->dateFin = $d; return $this; }
    public function getSalaireBase(): float { return $this->salaireBase; }
    public function setSalaireBase(float $s): self { $this->salaireBase = $s; return $this; }
    public function isPeriodeEssai(): bool { return $this->periodeEssai; }
    public function setPeriodeEssai(bool $p): self { $this->periodeEssai = $p; return $this; }
    public function isActif(): bool { return $this->actif; }
    public function setActif(bool $a): self { $this->actif = $a; return $this; }
    public function getEmploye(): Employe { return $this->employe; }
    public function setEmploye(Employe $e): self { $this->employe = $e; return $this; }
    public function getPoste(): ?Poste { return $this->poste; }
    public function setPoste(?Poste $p): self { $this->poste = $p; return $this; }
}
