<?php
namespace App\Repository;

use App\Entity\Departement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    // Calcule la somme des salaires de base des employes actifs d'un departement
    public function getSommeSalairesActifs(Departement $dept): float
    {
        return (float) $this->getEntityManager()
            ->createQuery('
                SELECT SUM(c.salaireBase)
                FROM App\Entity\Contrat c
                JOIN c.employe e
                WHERE e.departement = :dept AND c.actif = true
            ')
            ->setParameter('dept', $dept)
            ->getSingleScalarResult();
    }
}
