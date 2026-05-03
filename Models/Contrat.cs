using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    public enum TypeContrat { CDI, CDD, Stage, Freelance }

    [Table("contrats")]
    public class Contrat
    {
        [Column("id")]
        public int Id { get; set; }

        [Column("type_contrat")]
        public TypeContrat TypeContrat { get; set; }

        [Required]
        [Column("date_debut")]
        public DateTime DateDebut { get; set; }

        [Column("date_fin")]
        public DateTime? DateFin { get; set; }   // nullable si CDI

        [Column("salaire_base", TypeName = "decimal(18,2)")]
        public decimal SalaireBase { get; set; }

        [Column("periode_essai")]
        public bool PeriodeEssai { get; set; }

        // Clé étrangère
        [Column("employe_id")]
        public int EmployeId { get; set; }

        // Navigation
        public virtual Employe Employe { get; set; }
    }
}