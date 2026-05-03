<?php
namespace App\Repository;

use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employe::class);
    }

    // Recherche avec pagination (utilisee par le controller)
    public function findAllQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.departement', 'd')
            ->leftJoin('e.poste', 'p')
            ->addSelect('d', 'p')
            ->orderBy('e.nom', 'ASC');
    }
}
