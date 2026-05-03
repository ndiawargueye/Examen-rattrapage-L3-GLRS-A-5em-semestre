using System;
using System.Collections.Generic;
using System.Data.Entity;
using GRH.Models;

namespace GRH.Data
{
    public class GrhDbInitializer 
        : DropCreateDatabaseIfModelChanges<ApplicationDbContext>
    {
        protected override void Seed(ApplicationDbContext context)
        {
           
            var departements = new List<Departement>
            {
                new Departement
                {
                    Nom    = "Ressources Humaines",
                    Code   = "RH001",
                    Budget = 5000000
                },
                new Departement
                {
                    Nom    = "Informatique",
                    Code   = "IT002",
                    Budget = 8000000
                },
                new Departement
                {
                    Nom    = "Comptabilité",
                    Code   = "CPT03",
                    Budget = 3500000
                }
            };

            departements.ForEach(d => context.Departements.Add(d));
            context.SaveChanges();

        
            var postes = new List<Poste>
            {
                new Poste
                {
                    Intitule           = "Directeur RH",
                    NiveauHierarchique = 5,
                    SalaireMin         = 800000,
                    SalaireMax         = 1500000
                },
                new Poste
                {
                    Intitule           = "Développeur Senior",
                    NiveauHierarchique = 4,
                    SalaireMin         = 600000,
                    SalaireMax         = 1200000
                },
                new Poste
                {
                    Intitule           = "Développeur Junior",
                    NiveauHierarchique = 2,
                    SalaireMin         = 300000,
                    SalaireMax         = 600000
                },
                new Poste
                {
                    Intitule           = "Comptable",
                    NiveauHierarchique = 3,
                    SalaireMin         = 400000,
                    SalaireMax         = 800000
                },
                new Poste
                {
                    Intitule           = "Assistant RH",
                    NiveauHierarchique = 1,
                    SalaireMin         = 200000,
                    SalaireMax         = 400000
                }
            };

            postes.ForEach(p => context.Postes.Add(p));
            context.SaveChanges();

            var employes = new List<Employe>
            {
                new Employe
                {
                    Matricule      = "EMP001",
                    Nom            = "Diallo",
                    Prenom         = "Mamadou",
                    DateNaissance  = new DateTime(1985, 3, 15),
                    Email          = "m.diallo@sentech.sn",
                    Genre          = "M",
                    DepartementId  = departements[0].Id,  // RH
                    PosteId        = postes[0].Id          // Directeur RH
                },
                new Employe
                {
                    Matricule      = "EMP002",
                    Nom            = "Sow",
                    Prenom         = "Fatou",
                    DateNaissance  = new DateTime(1990, 7, 22),
                    Email          = "f.sow@sentech.sn",
                    Genre          = "F",
                    DepartementId  = departements[1].Id,  // IT
                    PosteId        = postes[1].Id          // Dev Senior
                },
                new Employe
                {
                    Matricule      = "EMP003",
                    Nom            = "Ndiaye",
                    Prenom         = "Ibrahima",
                    DateNaissance  = new DateTime(1995, 11, 8),
                    Email          = "i.ndiaye@sentech.sn",
                    Genre          = "M",
                    DepartementId  = departements[1].Id,  // IT
                    PosteId        = postes[2].Id          // Dev Junior
                },
                new Employe
                {
                    Matricule      = "EMP004",
                    Nom            = "Ba",
                    Prenom         = "Aissatou",
                    DateNaissance  = new DateTime(1988, 5, 30),
                    Email          = "a.ba@sentech.sn",
                    Genre          = "F",
                    DepartementId  = departements[2].Id,  // Comptabilité
                    PosteId        = postes[3].Id          // Comptable
                },
                new Employe
                {
                    Matricule      = "EMP005",
                    Nom            = "Fall",
                    Prenom         = "Ousmane",
                    DateNaissance  = new DateTime(1992, 1, 17),
                    Email          = "o.fall@sentech.sn",
                    Genre          = "M",
                    DepartementId  = departements[0].Id,  // RH
                    PosteId        = postes[4].Id          // Assistant RH
                },
                new Employe
                {
                    Matricule      = "EMP006",
                    Nom            = "Cissé",
                    Prenom         = "Mariama",
                    DateNaissance  = new DateTime(1993, 9, 5),
                    Email          = "m.cisse@sentech.sn",
                    Genre          = "F",
                    DepartementId  = departements[1].Id,  // IT
                    PosteId        = postes[2].Id          // Dev Junior
                },
                new Employe
                {
                    Matricule      = "EMP007",
                    Nom            = "Touré",
                    Prenom         = "Cheikh",
                    DateNaissance  = new DateTime(1987, 4, 12),
                    Email          = "c.toure@sentech.sn",
                    Genre          = "M",
                    DepartementId  = departements[2].Id,  // Comptabilité
                    PosteId        = postes[3].Id          // Comptable
                },
                new Employe
                {
                    Matricule      = "EMP008",
                    Nom            = "Sarr",
                    Prenom         = "Khady",
                    DateNaissance  = new DateTime(1996, 6, 25),
                    Email          = "k.sarr@sentech.sn",
                    Genre          = "F",
                    DepartementId  = departements[0].Id,  // RH
                    PosteId        = postes[4].Id          // Assistant RH
                },
                new Employe
                {
                    Matricule      = "EMP009",
                    Nom            = "Mbaye",
                    Prenom         = "Serigne",
                    DateNaissance  = new DateTime(1991, 2, 28),
                    Email          = "s.mbaye@sentech.sn",
                    Genre          = "M",
                    DepartementId  = departements[1].Id,  // IT
                    PosteId        = postes[1].Id          // Dev Senior
                },
                new Employe
                {
                    Matricule      = "EMP010",
                    Nom            = "Gueye",
                    Prenom         = "Rokhaya",
                    DateNaissance  = new DateTime(1994, 8, 10),
                    Email          = "r.gueye@sentech.sn",
                    Genre          = "F",
                    DepartementId  = departements[2].Id,  // Comptabilité
                    PosteId        = postes[3].Id          // Comptable
                }
            };

            employes.ForEach(e => context.Employes.Add(e));
            context.SaveChanges();

       
            var contrats = new List<Contrat>
            {
                new Contrat {
                    EmployeId    = employes[0].Id,
                    TypeContrat  = TypeContrat.CDI,
                    DateDebut    = new DateTime(2015, 1, 5),
                    DateFin      = null,               // CDI = pas de fin
                    SalaireBase  = 1200000,
                    PeriodeEssai = false
                },
                new Contrat {
                    EmployeId    = employes[1].Id,
                    TypeContrat  = TypeContrat.CDI,
                    DateDebut    = new DateTime(2018, 3, 1),
                    DateFin      = null,
                    SalaireBase  = 950000,
                    PeriodeEssai = false
                },
                new Contrat {
                    EmployeId    = employes[2].Id,
                    TypeContrat  = TypeContrat.CDD,
                    DateDebut    = new DateTime(2023, 6, 1),
                    DateFin      = new DateTime(2024, 5, 31),
                    SalaireBase  = 450000,
                    PeriodeEssai = true
                },
                new Contrat {
                    EmployeId    = employes[3].Id,
                    TypeContrat  = TypeContrat.CDI,
                    DateDebut    = new DateTime(2017, 9, 15),
                    DateFin      = null,
                    SalaireBase  = 700000,
                    PeriodeEssai = false
                },
                new Contrat {
                    EmployeId    = employes[4].Id,
                    TypeContrat  = TypeContrat.CDD,
                    DateDebut    = new DateTime(2024, 1, 2),
                    DateFin      = new DateTime(2024, 12, 31),
                    SalaireBase  = 300000,
                    PeriodeEssai = true
                }
            };

            contrats.ForEach(c => context.Contrats.Add(c));
            context.SaveChanges();

            base.Seed(context);
        }
    }
}