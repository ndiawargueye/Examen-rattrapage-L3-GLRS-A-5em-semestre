<?php
namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
#[ORM\Table(name: 'evaluation')]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $periode;

    #[ORM\Column(type: 'float')]
    #[Assert\Range(min: 0, max: 20)]
    private float $note;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $dateEvaluation;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private Employe $employe;

    public function getId(): ?int { return $this->id; }
    public function getPeriode(): string { return $this->periode; }
    public function setPeriode(string $p): self { $this->periode = $p; return $this; }
    public function getNote(): float { return $this->note; }
    public function setNote(float $n): self { $this->note = $n; return $this; }
    public function getCommentaire(): ?string { return $this->commentaire; }
    public function setCommentaire(?string $c): self { $this->commentaire = $c; return $this; }
    public function getDateEvaluation(): \DateTimeInterface { return $this->dateEvaluation; }
    public function setDateEvaluation(\DateTimeInterface $d): self { $this->dateEvaluation = $d; return $this; }
    public function getEmploye(): Employe { return $this->employe; }
    public function setEmploye(Employe $e): self { $this->employe = $e; return $this; }
}
