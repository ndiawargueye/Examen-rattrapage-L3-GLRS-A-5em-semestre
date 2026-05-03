<?php
namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
#[ORM\Table(name: 'poste')]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private string $intitule;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 1, max: 5)]
    private int $niveauHierarchique;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive]
    private float $salaireMin;

    #[ORM\Column(type: 'float')]
    #[Assert\Positive]
    private float $salaireMax;

    public function getId(): ?int { return $this->id; }
    public function getIntitule(): string { return $this->intitule; }
    public function setIntitule(string $intitule): self { $this->intitule = $intitule; return $this; }
    public function getNiveauHierarchique(): int { return $this->niveauHierarchique; }
    public function setNiveauHierarchique(int $n): self { $this->niveauHierarchique = $n; return $this; }
    public function getSalaireMin(): float { return $this->salaireMin; }
    public function setSalaireMin(float $s): self { $this->salaireMin = $s; return $this; }
    public function getSalaireMax(): float { return $this->salaireMax; }
    public function setSalaireMax(float $s): self { $this->salaireMax = $s; return $this; }
}
