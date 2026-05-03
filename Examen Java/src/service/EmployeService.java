package service;

import model.Employe;
import repository.EmployeRepository;

public class EmployeService {

    private EmployeRepository repository = new EmployeRepository();

    public void inscrireEmploye(String matricule, String nom, String prenom,
            String departement, double salaireBrut) {

        if (matricule == null || matricule.trim().isEmpty()) {
            System.out.println("Erreur : le matricule ne peut pas etre vide.");
            return;
        }
        if (repository.rechercherParMatricule(matricule) != null) {
            System.out.println("Erreur : un employe avec ce matricule existe deja.");
            return;
        }
        if (nom == null || nom.trim().isEmpty()) {
            System.out.println("Erreur : le nom ne peut pas etre vide.");
            return;
        }
        if (prenom == null || prenom.trim().isEmpty()) {
            System.out.println("Erreur : le prenom ne peut pas etre vide.");
            return;
        }
        if (salaireBrut <= 0) {
            System.out.println("Erreur : le salaire brut doit etre superieur a 0.");
            return;
        }

        Employe e = new Employe(matricule, nom, prenom, departement, salaireBrut);
        repository.ajouter(e);
        System.out.println("Employe enregistre avec succes.");
    }

    public void afficherTousLesEmployes() {
        Employe[] liste = repository.listerTous();
        if (liste.length == 0) {
            System.out.println("Aucun employe enregistre.");
            return;
        }
        for (Employe e : liste) {
            e.afficher();
        }
    }

    public void rechercherEtAfficher(String matricule) {
        Employe e = repository.rechercherParMatricule(matricule);
        if (e == null) {
            System.out.println("Aucun employe trouve avec le matricule : " + matricule);
        } else {
            e.afficher();
        }
    }

    public void afficherStatistiques() {
        Employe[] liste = repository.listerTous();
        int total = liste.length;

        if (total == 0) {
            System.out.println("Aucun employe enregistre.");
            return;
        }

        double sommeBrut = 0;
        double sommeNet = 0;
        for (Employe e : liste) {
            sommeBrut += e.getSalaireBrut();
            sommeNet += e.calculerSalaireNet();
        }

        System.out.println("===== STATISTIQUES =====");
        System.out.println("Nombre d'employes    : " + total);
        System.out.printf("Salaire brut moyen   : %.0f F%n", sommeBrut / total);
        System.out.printf("Salaire net moyen    : %.0f F%n", sommeNet / total);
        System.out.println("========================");
    }
}
