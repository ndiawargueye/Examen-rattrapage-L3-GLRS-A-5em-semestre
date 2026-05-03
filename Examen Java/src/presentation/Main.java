package presentation;

import service.EmployeService;
import java.util.Scanner;

public class Main {

    public static void main(String[] args) {

        EmployeService service = new EmployeService();
        Scanner scanner = new Scanner(System.in);
        int choix;

        do {
            System.out.println("\n===== GESTION DES EMPLOYES =====");
            System.out.println("1. Ajouter un employe");
            System.out.println("2. Afficher tous les employes");
            System.out.println("3. Rechercher un employe par matricule");
            System.out.println("4. Afficher les statistiques");
            System.out.println("5. Quitter");
            System.out.println("================================");
            System.out.print("Votre choix : ");

            if (!scanner.hasNextInt()) {
                System.out.println("Choix invalide, entrez un nombre entre 1 et 5.");
                scanner.next();
                choix = -1;
                continue;
            }
            choix = scanner.nextInt();
            scanner.nextLine();

            switch (choix) {
                case 1:
                    System.out.println("=== Ajout d'un employe ===");
                    System.out.print("Matricule   : ");
                    String matricule = scanner.nextLine();

                    System.out.print("Nom         : ");
                    String nom = scanner.nextLine();

                    System.out.print("Prenom      : ");
                    String prenom = scanner.nextLine();

                    System.out.print("Departement : ");
                    String departement = scanner.nextLine();

                    System.out.print("Salaire brut: ");
                    double salaire = scanner.nextDouble();
                    scanner.nextLine();

                    service.inscrireEmploye(matricule, nom, prenom, departement, salaire);
                    break;

                case 2:
                    service.afficherTousLesEmployes();
                    break;

                case 3:
                    System.out.println("=== Recherche ===");
                    System.out.print("Matricule a rechercher : ");
                    String mat = scanner.nextLine();
                    service.rechercherEtAfficher(mat);
                    break;

                case 4:
                    service.afficherStatistiques();
                    break;

                case 5:
                    System.out.println("Au revoir !");
                    break;

                default:
                    System.out.println("Choix invalide. Choisissez entre 1 et 5.");
            }

        } while (choix != 5);

        scanner.close();
    }
}
