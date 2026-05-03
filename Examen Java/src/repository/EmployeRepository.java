package repository;

import model.Employe;

public class EmployeRepository {

    private Employe[] employes = new Employe[10]; // taille max 10
    private int count = 0;

    public void ajouter(Employe e) {
        if (count >= employes.length) {
            System.out.println("Erreur : capacite maximale atteinte (10 employes).");
            return;
        }
        employes[count] = e;
        count++;
    }

    public Employe[] listerTous() {
        Employe[] result = new Employe[count];
        for (int i = 0; i < count; i++) {
            result[i] = employes[i];
        }
        return result;
    }

    public Employe rechercherParMatricule(String matricule) {
        for (int i = 0; i < count; i++) {
            if (employes[i].getMatricule().equalsIgnoreCase(matricule)) {
                return employes[i];
            }
        }
        return null;
    }

    public int compter() {
        return count;
    }
}
