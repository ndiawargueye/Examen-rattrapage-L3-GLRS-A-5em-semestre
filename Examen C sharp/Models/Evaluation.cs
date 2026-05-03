using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    [Table("evaluations")]
    public class Evaluation
    {
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("periode")]
        public string Periode { get; set; }

        [Range(0, 20)]
        [Column("note", TypeName = "decimal(4,2)")]
        public decimal Note { get; set; }
        [Column("commentaire")]
        public string Commentaire { get; set; }

        [Column("date_evaluation")]
        public DateTime DateEvaluation { get; set; }

  
        [Column("employe_id")]
        public int EmployeId { get; set; }

    
        public virtual Employe Employe { get; set; }
    }
}