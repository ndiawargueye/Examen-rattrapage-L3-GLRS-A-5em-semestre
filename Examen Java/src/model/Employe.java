package model;

public class Employe {

    private String matricule;
    private String nom;
    private String prenom;
    private String departement;
    private double salaireBrut;

    public Employe(String matricule, String nom, String prenom, String departement, double salaireBrut) {
        this.matricule = matricule;
        this.nom = nom;
        this.prenom = prenom;
        this.departement = departement;
        this.salaireBrut = salaireBrut;
    }

    public String getMatricule() {
        return matricule;
    }

    public String getNom() {
        return nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public String getDepartement() {
        return departement;
    }

    public double getSalaireBrut() {
        return salaireBrut;
    }

    public double calculerSalaireNet() {
        return salaireBrut * (1 - 0.22);
    }

    public void afficher() {
        System.out.println("===== FICHE EMPLOYE =====");
        System.out.println("Matricule   : " + matricule);
        System.out.println("Nom         : " + nom);
        System.out.println("Prenom      : " + prenom);
        System.out.println("Departement : " + departement);
        System.out.printf("Salaire brut : %.0f F%n", salaireBrut);
        System.out.printf("Charges (22%%): %.0f F%n", salaireBrut * 0.22);
        System.out.printf("Salaire net  : %.0f F%n", calculerSalaireNet());
        System.out.println("=========================");
    }
}
