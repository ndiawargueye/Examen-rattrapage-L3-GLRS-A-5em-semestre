<?php
namespace App\Service;

use App\Entity\Contrat;
use App\Entity\Employe;
use App\Model\ServiceResult;
use App\Repository\ContratRepository;
use App\Repository\CongeRepository;
use App\Repository\DepartementRepository;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EmployeService implements IEmployeService
{
    public function __construct(
        private EntityManagerInterface $em,
        private EmployeRepository      $employeRepo,
        private ContratRepository      $contratRepo,
        private CongeRepository        $congeRepo,
        private DepartementRepository  $deptRepo,
    ) {}

    // ----------------------------------------------------------------
    // Creer un employe — RG05 : age >= 18 ans
    // ----------------------------------------------------------------
    public function creerEmploye(Employe $employe): ServiceResult
    {
        try {
            if ($employe->getAge() < 18) {
                return ServiceResult::fail('RG05 : L\'employe doit avoir au moins 18 ans.');
            }
            $this->em->persist($employe);
            $this->em->flush();
            return ServiceResult::ok($employe);
        } catch (\Exception $e) {
            return ServiceResult::fail('Erreur lors de la creation : ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Supprimer un employe — RG03 : pas de CDI actif ni conge en attente
    // ----------------------------------------------------------------
    public function supprimerEmploye(int $id): ServiceResult
    {
        try {
            $employe = $this->employeRepo->find($id);
            if (!$employe) {
                return ServiceResult::fail('Employe introuvable.');
            }
            if ($this->contratRepo->hasCdiActif($employe)) {
                return ServiceResult::fail('RG03 : Impossible de supprimer un employe avec un CDI actif.');
            }
            if ($this->congeRepo->hasCongesEnAttente($employe)) {
                return ServiceResult::fail('RG03 : Impossible de supprimer un employe avec des conges en attente.');
            }
            $this->em->remove($employe);
            $this->em->flush();
            return ServiceResult::ok();
        } catch (\Exception $e) {
            return ServiceResult::fail('Erreur : ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Ajouter un contrat — RG01 + RG02
    // ----------------------------------------------------------------
    public function ajouterContrat(Employe $employe, Contrat $contrat): ServiceResult
    {
        try {
            // RG01 : un seul contrat actif
            if ($this->contratRepo->findContratActif($employe)) {
                return ServiceResult::fail('RG01 : L\'employe a deja un contrat actif.');
            }

            // RG02 : salaire dans la fourchette du poste
            $poste = $contrat->getPoste();
            if ($poste) {
                if ($contrat->getSalaireBase() < $poste->getSalaireMin()
                    || $contrat->getSalaireBase() > $poste->getSalaireMax()) {
                    return ServiceResult::fail(sprintf(
                        'RG02 : Le salaire doit etre entre %.2f et %.2f.',
                        $poste->getSalaireMin(),
                        $poste->getSalaireMax()
                    ));
                }
            }

            $contrat->setEmploye($employe);
            $this->em->persist($contrat);
            $this->em->flush();
            return ServiceResult::ok($contrat);
        } catch (\Exception $e) {
            return ServiceResult::fail('Erreur : ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Transfert d'employe — transaction : cloture ancien contrat + nouveau
    // ----------------------------------------------------------------
    public function transfererEmploye(Employe $employe, int $nouveauDeptId, Contrat $nouveauContrat): ServiceResult
    {
        $this->em->beginTransaction();
        try {
            // Cloturer l'ancien contrat
            $ancienContrat = $this->contratRepo->findContratActif($employe);
            if ($ancienContrat) {
                $ancienContrat->setActif(false);
                $ancienContrat->setDateFin(new \DateTime());
            }

            // Changer de departement
            $nouveauDept = $this->deptRepo->find($nouveauDeptId);
            if (!$nouveauDept) {
                $this->em->rollback();
                return ServiceResult::fail('Departement cible introuvable.');
            }

            // RG07 : verifier le budget
            $sommeSalaires = $this->deptRepo->getSommeSalairesActifs($nouveauDept);
            if ($sommeSalaires + $nouveauContrat->getSalaireBase() > $nouveauDept->getBudget()) {
                $this->em->rollback();
                return ServiceResult::fail('RG07 : Le budget du departement serait depasse.');
            }

            $employe->setDepartement($nouveauDept);
            $nouveauContrat->setEmploye($employe);
            $this->em->persist($nouveauContrat);
            $this->em->flush();
            $this->em->commit();
            return ServiceResult::ok($employe);
        } catch (\Exception $e) {
            $this->em->rollback();
            return ServiceResult::fail('Erreur transaction : ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Ajouter une evaluation — RG06 : anciennete >= 6 mois
    // ----------------------------------------------------------------
    public function verifierAnciennete(Employe $employe): ServiceResult
    {
        if ($employe->getAncienneteEnMois() < 6) {
            return ServiceResult::fail('RG06 : L\'employe doit avoir au moins 6 mois d\'anciennete.');
        }
        return ServiceResult::ok();
    }

    // ----------------------------------------------------------------
    // Verifier les jours de conge — RG04 : max 30 jours annuels
    // ----------------------------------------------------------------
    public function verifierConge(Employe $employe, int $nbJoursDemandes): ServiceResult
    {
        $annee = (int)(new \DateTime())->format('Y');
        $total = $this->congeRepo->getTotalJoursAnnuels($employe, $annee);
        if ($total + $nbJoursDemandes > 30) {
            return ServiceResult::fail('RG04 : La limite de 30 jours de conge annuel serait depassee.');
        }
        return ServiceResult::ok();
    }
}
