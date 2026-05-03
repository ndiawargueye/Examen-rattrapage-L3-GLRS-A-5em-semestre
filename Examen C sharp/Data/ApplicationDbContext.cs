using System;
using System.Data.Entity;
using System.Data.Entity.ModelConfiguration.Conventions;
using GRH.Models;
using Npgsql;

namespace GRH.Data
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext()
            : base("name=GrhConnection")
        {
      
            this.Configuration.LazyLoadingEnabled = true;
            this.Configuration.ProxyCreationEnabled = true;
        }

     
        public DbSet<Departement> Departements { get; set; }
        public DbSet<Poste>       Postes       { get; set; }
        public DbSet<Employe>     Employes     { get; set; }
        public DbSet<Contrat>     Contrats     { get; set; }
        public DbSet<Evaluation>  Evaluations  { get; set; }
        public DbSet<Conge>       Conges       { get; set; }

        protected override void OnModelCreating(DbModelBuilder modelBuilder)
        {
            
            modelBuilder.Conventions.Remove<PluralizingTableNameConvention>();

            
            modelBuilder.Entity<Departement>()
                .ToTable("departements")
                .HasKey(d => d.Id);

            modelBuilder.Entity<Departement>()
                .Property(d => d.Id)
                .HasColumnName("id")
                .IsRequired();

            modelBuilder.Entity<Departement>()
                .Property(d => d.Nom)
                .HasColumnName("nom")
                .IsRequired()
                .HasMaxLength(50);

            modelBuilder.Entity<Departement>()
                .Property(d => d.Code)
                .HasColumnName("code")
                .IsRequired()
                .HasMaxLength(6);

            modelBuilder.Entity<Departement>()
                .HasIndex(d => d.Code)
                .IsUnique();                   

            modelBuilder.Entity<Departement>()
                .Property(d => d.Budget)
                .HasColumnName("budget")
                .HasPrecision(18, 2);

        
            modelBuilder.Entity<Poste>()
                .ToTable("postes")
                .HasKey(p => p.Id);

            modelBuilder.Entity<Poste>()
                .Property(p => p.Id)
                .HasColumnName("id");

            modelBuilder.Entity<Poste>()
                .Property(p => p.Intitule)
                .HasColumnName("intitule")
                .IsRequired();

            modelBuilder.Entity<Poste>()
                .Property(p => p.NiveauHierarchique)
                .HasColumnName("niveau_hierarchique")
                .IsRequired();

            modelBuilder.Entity<Poste>()
                .Property(p => p.SalaireMin)
                .HasColumnName("salaire_min")
                .HasPrecision(18, 2);

            modelBuilder.Entity<Poste>()
                .Property(p => p.SalaireMax)
                .HasColumnName("salaire_max")
                .HasPrecision(18, 2);

      
            modelBuilder.Entity<Employe>()
                .ToTable("employes")
                .HasKey(e => e.Id);

            modelBuilder.Entity<Employe>()
                .Property(e => e.Id)
                .HasColumnName("id");

            modelBuilder.Entity<Employe>()
                .Property(e => e.Matricule)
                .HasColumnName("matricule")
                .IsRequired();

          
            modelBuilder.Entity<Employe>()
                .HasIndex(e => e.Matricule)
                .IsUnique()
                .HasName("IX_employe_matricule");

            modelBuilder.Entity<Employe>()
                .Property(e => e.Nom)
                .HasColumnName("nom")
                .IsRequired();

            modelBuilder.Entity<Employe>()
                .Property(e => e.Prenom)
                .HasColumnName("prenom")
                .IsRequired();

            modelBuilder.Entity<Employe>()
                .Property(e => e.DateNaissance)
                .HasColumnName("date_naissance")
                .IsRequired();

            modelBuilder.Entity<Employe>()
                .Property(e => e.Email)
                .HasColumnName("email")
                .IsRequired();

           
            modelBuilder.Entity<Employe>()
                .HasIndex(e => e.Email)
                .IsUnique()
                .HasName("IX_employe_email");

            modelBuilder.Entity<Employe>()
                .Property(e => e.Genre)
                .HasColumnName("genre");

            modelBuilder.Entity<Employe>()
                .Property(e => e.DepartementId)
                .HasColumnName("departement_id");

            modelBuilder.Entity<Employe>()
                .Property(e => e.PosteId)
                .HasColumnName("poste_id");

        
            modelBuilder.Entity<Contrat>()
                .ToTable("contrats")
                .HasKey(c => c.Id);

            modelBuilder.Entity<Contrat>()
                .Property(c => c.Id)
                .HasColumnName("id");

            modelBuilder.Entity<Contrat>()
                .Property(c => c.TypeContrat)
                .HasColumnName("type_contrat")
                .IsRequired();

            modelBuilder.Entity<Contrat>()
                .Property(c => c.DateDebut)
                .HasColumnName("date_debut")
                .IsRequired();

            modelBuilder.Entity<Contrat>()
                .Property(c => c.DateFin)
                .HasColumnName("date_fin")
                .IsOptional();              

            modelBuilder.Entity<Contrat>()
                .Property(c => c.SalaireBase)
                .HasColumnName("salaire_base")
                .HasPrecision(18, 2);

            modelBuilder.Entity<Contrat>()
                .Property(c => c.PeriodeEssai)
                .HasColumnName("periode_essai");

            modelBuilder.Entity<Contrat>()
                .Property(c => c.EmployeId)
                .HasColumnName("employe_id");

          
            modelBuilder.Entity<Evaluation>()
                .ToTable("evaluations")
                .HasKey(ev => ev.Id);

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.Id)
                .HasColumnName("id");

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.Periode)
                .HasColumnName("periode")
                .IsRequired();

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.Note)
                .HasColumnName("note")
                .HasPrecision(4, 2);

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.Commentaire)
                .HasColumnName("commentaire");

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.DateEvaluation)
                .HasColumnName("date_evaluation")
                .IsRequired();

            modelBuilder.Entity<Evaluation>()
                .Property(ev => ev.EmployeId)
                .HasColumnName("employe_id");

          
            modelBuilder.Entity<Conge>()
                .ToTable("conges")
                .HasKey(c => c.Id);

            modelBuilder.Entity<Conge>()
                .Property(c => c.Id)
                .HasColumnName("id");

            modelBuilder.Entity<Conge>()
                .Property(c => c.TypeConge)
                .HasColumnName("type_conge")
                .IsRequired();

            modelBuilder.Entity<Conge>()
                .Property(c => c.DateDebut)
                .HasColumnName("date_debut")
                .IsRequired();

            modelBuilder.Entity<Conge>()
                .Property(c => c.DateFin)
                .HasColumnName("date_fin")
                .IsRequired();

            modelBuilder.Entity<Conge>()
                .Property(c => c.Statut)
                .HasColumnName("statut")
                .IsRequired();

            modelBuilder.Entity<Conge>()
                .Property(c => c.Motif)
                .HasColumnName("motif");

            modelBuilder.Entity<Conge>()
                .Property(c => c.EmployeId)
                .HasColumnName("employe_id");

          
            modelBuilder.Entity<Employe>()
                .HasRequired(e => e.Departement)
                .WithMany(d => d.Employes)
                .HasForeignKey(e => e.DepartementId)
                .WillCascadeOnDelete(false);

          
            modelBuilder.Entity<Employe>()
                .HasRequired(e => e.Poste)
                .WithMany(p => p.Employes)
                .HasForeignKey(e => e.PosteId)
                .WillCascadeOnDelete(false);

    
            modelBuilder.Entity<Contrat>()
                .HasRequired(c => c.Employe)
                .WithMany(e => e.Contrats)
                .HasForeignKey(c => c.EmployeId)
                .WillCascadeOnDelete(true);

           
            modelBuilder.Entity<Evaluation>()
                .HasRequired(ev => ev.Employe)
                .WithMany(e => e.Evaluations)
                .HasForeignKey(ev => ev.EmployeId)
                .WillCascadeOnDelete(true);

           
            modelBuilder.Entity<Conge>()
                .HasRequired(c => c.Employe)
                .WithMany(e => e.Conges)
                .HasForeignKey(c => c.EmployeId)
                .WillCascadeOnDelete(true);

            base.OnModelCreating(modelBuilder);
        }
    }
}