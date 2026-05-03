<?php
namespace App\Repository;

use App\Entity\Conge;
use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conge::class);
    }

    // Calcule le total de jours de conge annuel pour l'annee en cours
    public function getTotalJoursAnnuels(Employe $employe, int $annee): int
    {
        $conges = $this->createQueryBuilder('c')
            ->where('c.employe = :emp')
            ->andWhere('c.typeConge = :type')
            ->andWhere('YEAR(c.dateDebut) = :annee')
            ->setParameter('emp', $employe)
            ->setParameter('type', 'ANNUEL')
            ->setParameter('annee', $annee)
            ->getQuery()->getResult();

        return array_sum(array_map(fn(Conge $c) => $c->getNbJours(), $conges));
    }

    // Verifie si l'employe a des conges en attente
    public function hasCongesEnAttente(Employe $employe): bool
    {
        $c = $this->findOneBy(['employe' => $employe, 'statut' => 'EN_ATTENTE']);
        return $c !== null;
    }
}
