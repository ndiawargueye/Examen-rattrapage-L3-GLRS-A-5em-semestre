using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    public enum TypeConge   { Annuel, Maladie, Maternite, SansGageSalaire }
    public enum StatutConge { EnAttente, Approuve, Refuse }

    [Table("conges")]
    public class Conge
    {
        [Column("id")]
        public int Id { get; set; }
        [Column("type_conge")]
        public TypeConge TypeConge { get; set; }

        [Required]
        [Column("date_debut")]
        public DateTime DateDebut { get; set; 
        [Required]
        [Column("date_fin")]
        public DateTime DateFin { get; set; }

        [Column("statut")]
        public StatutConge Statut { get; set; }

        [Column("motif")]
        public string Motif { get; set; }

   
        [Column("employe_id")]
        public int EmployeId { get; set; }

        
        public virtual Employe Employe { get; set; }
    }
}