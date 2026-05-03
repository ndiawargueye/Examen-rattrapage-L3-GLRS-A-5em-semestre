using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    [Table("departements")]
    public class Departement
    {
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [StringLength(50, MinimumLength = 3)]
        [Column("nom")]
        public string Nom { get; set; }

        [Required]
        [StringLength(6, MinimumLength = 3)]
        [Column("code")]
        public string Code { get; set; }

        [Column("budget", TypeName = "decimal(18,2)")]
        public decimal Budget { get; set; }

     
        public virtual ICollection<Employe> Employes { get; set; }
    }
}