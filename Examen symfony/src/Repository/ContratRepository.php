<?php
namespace App\Repository;

use App\Entity\Contrat;
use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrat::class);
    }

    // Retourne le contrat actif d'un employe (null si aucun)
    public function findContratActif(Employe $employe): ?Contrat
    {
        return $this->findOneBy(['employe' => $employe, 'actif' => true]);
    }

    // Retourne tous les contrats actifs CDI d'un employe
    public function hasCdiActif(Employe $employe): bool
    {
        $c = $this->findOneBy(['employe' => $employe, 'typeContrat' => 'CDI', 'actif' => true]);
        return $c !== null;
    }
}
