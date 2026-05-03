<?php
namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
#[ORM\Table(name: 'employe')]
#[UniqueEntity(fields: ['matricule'], message: 'Ce matricule existe deja.')]
#[UniqueEntity(fields: ['email'], message: 'Cet email est deja utilise.')]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank]
    private string $matricule;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private string $nom;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private string $prenom;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    private \DateTimeInterface $dateNaissance;

    #[ORM\Column(type: 'string', length: 1)]
    #[Assert\Choice(choices: ['M', 'F'])]
    private string $genre;

    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'employes')]
    private ?Departement $departement = null;

    #[ORM\ManyToOne(targetEntity: Poste::class)]
    private ?Poste $poste = null;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Contrat::class)]
    private Collection $contrats;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Evaluation::class)]
    private Collection $evaluations;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Conge::class)]
    private Collection $conges;

    public function __construct()
    {
        $this->contrats    = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->conges      = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getMatricule(): string { return $this->matricule; }
    public function setMatricule(string $m): self { $this->matricule = $m; return $this; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $n): self { $this->nom = $n; return $this; }
    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $p): self { $this->prenom = $p; return $this; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $e): self { $this->email = $e; return $this; }
    public function getDateNaissance(): \DateTimeInterface { return $this->dateNaissance; }
    public function setDateNaissance(\DateTimeInterface $d): self { $this->dateNaissance = $d; return $this; }
    public function getGenre(): string { return $this->genre; }
    public function setGenre(string $g): self { $this->genre = $g; return $this; }
    public function getDepartement(): ?Departement { return $this->departement; }
    public function setDepartement(?Departement $d): self { $this->departement = $d; return $this; }
    public function getPoste(): ?Poste { return $this->poste; }
    public function setPoste(?Poste $p): self { $this->poste = $p; return $this; }
    public function getContrats(): Collection { return $this->contrats; }
    public function getEvaluations(): Collection { return $this->evaluations; }
    public function getConges(): Collection { return $this->conges; }

    // Retourne l'age en annees
    public function getAge(): int
    {
        return (new \DateTime())->diff($this->dateNaissance)->y;
    }

    // Retourne l'anciennete en mois depuis le premier contrat
    public function getAncienneteEnMois(): int
    {
        if ($this->contrats->isEmpty()) return 0;
        $premier = $this->contrats->first()->getDateDebut();
        return (new \DateTime())->diff($premier)->m
             + ((new \DateTime())->diff($premier)->y * 12);
    }
}
