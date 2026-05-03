<?php
namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[ORM\Table(name: 'departement')]
#[UniqueEntity(fields: ['code'], message: 'Ce code de departement existe deja.')]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 6, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 6)]
    private string $code;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive]
    private float $budget;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Employe::class)]
    private Collection $employes;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
    public function getCode(): string { return $this->code; }
    public function setCode(string $code): self { $this->code = $code; return $this; }
    public function getBudget(): float { return $this->budget; }
    public function setBudget(float $budget): self { $this->budget = $budget; return $this; }
    public function getEmployes(): Collection { return $this->employes; }
}
