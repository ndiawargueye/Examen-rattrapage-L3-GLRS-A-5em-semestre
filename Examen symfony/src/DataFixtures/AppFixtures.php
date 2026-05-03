<?php
namespace App\DataFixtures;

use App\Entity\Departement;
use App\Entity\Employe;
use App\Entity\Poste;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --- 3 Departements ---
        $depts = [];
        $data  = [
            ['Informatique', 'INFO', 5000000],
            ['Ressources Humaines', 'RH', 3000000],
            ['Finance', 'FIN', 4000000],
        ];
        foreach ($data as [$nom, $code, $budget]) {
            $d = (new Departement())->setNom($nom)->setCode($code)->setBudget($budget);
            $manager->persist($d);
            $depts[] = $d;
        }

        // --- 5 Postes ---
        $postes = [];
        $postData = [
            ['Developpeur Junior',   1, 300000, 500000],
            ['Developpeur Senior',   3, 500000, 900000],
            ['Chef de Projet',       4, 800000, 1200000],
            ['Charge RH',            2, 350000, 600000],
            ['Comptable',            2, 350000, 650000],
        ];
        foreach ($postData as [$intitule, $niveau, $min, $max]) {
            $p = (new Poste())
                ->setIntitule($intitule)
                ->setNiveauHierarchique($niveau)
                ->setSalaireMin($min)
                ->setSalaireMax($max);
            $manager->persist($p);
            $postes[] = $p;
        }

        // --- 10 Employes ---
        $employes = [
            ['EMP001', 'Diallo',   'Fatou',    'F', '1990-05-12', 0, 0],
            ['EMP002', 'Ndiaye',   'Moussa',   'M', '1988-03-22', 0, 1],
            ['EMP003', 'Fall',     'Aissatou', 'F', '1995-07-01', 1, 2],
            ['EMP004', 'Sow',      'Ibrahima', 'M', '1992-11-15', 1, 3],
            ['EMP005', 'Ba',       'Mariama',  'F', '1993-02-28', 2, 4],
            ['EMP006', 'Mbaye',    'Omar',     'M', '1991-08-10', 0, 0],
            ['EMP007', 'Sarr',     'Khady',    'F', '1996-04-05', 1, 1],
            ['EMP008', 'Diop',     'Cheikh',   'M', '1989-12-20', 2, 2],
            ['EMP009', 'Cisse',    'Rokhaya',  'F', '1994-09-17', 0, 3],
            ['EMP010', 'Gueye',    'Pape',     'M', '1987-06-30', 1, 4],
        ];

        foreach ($employes as $i => [$mat, $nom, $prenom, $genre, $dob, $deptIdx, $posteIdx]) {
            $e = (new Employe())
                ->setMatricule($mat)
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setGenre($genre)
                ->setEmail(strtolower($prenom . '.' . $nom . '@sentech.sn'))
                ->setDateNaissance(new \DateTime($dob))
                ->setDepartement($depts[$deptIdx])
                ->setPoste($postes[$posteIdx]);
            $manager->persist($e);
        }

        $manager->flush();
    }
}
