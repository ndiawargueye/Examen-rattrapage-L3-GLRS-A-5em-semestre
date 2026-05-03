using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    [Table("employes")]
    public class Employe
    {
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("matricule")]
        public string Matricule { get; set; }

        [Required]
        [Column("nom")]
        public string Nom { get; set; }

        [Required]
        [Column("prenom")]
        public string Prenom { get; set; }

        [Required]
        [Column("date_naissance")]
        public DateTime DateNaissance { get; set; }

        [Required]
        [EmailAddress]
        [Column("email")]
        public string Email { get; set; }

        [Column("genre")]
        public string Genre { get; set; }

 
        [Column("departement_id")]
        public int DepartementId { get; set; }

        [Column("poste_id")]
        public int PosteId { get; set; }

        public virtual Departement Departement { get; set; }
        public virtual Poste Poste { get; set; }
        public virtual ICollection<Contrat>    Contrats    { get; set; }
        public virtual ICollection<Evaluation> Evaluations { get; set; }
        public virtual ICollection<Conge>      Conges      { get; set; }
    }
}