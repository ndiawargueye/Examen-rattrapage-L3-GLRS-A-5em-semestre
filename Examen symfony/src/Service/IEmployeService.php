<?php
namespace App\Service;

use App\Entity\Employe;
use App\Entity\Contrat;
use App\Model\ServiceResult;

interface IEmployeService
{
    public function creerEmploye(Employe $employe): ServiceResult;
    public function supprimerEmploye(int $id): ServiceResult;
    public function ajouterContrat(Employe $employe, Contrat $contrat): ServiceResult;
    public function transfererEmploye(Employe $employe, int $nouveauDepartementId, Contrat $nouveauContrat): ServiceResult;
}
