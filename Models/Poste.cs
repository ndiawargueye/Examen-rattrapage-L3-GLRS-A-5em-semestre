using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace GRH.Models
{
    [Table("postes")]
    public class Poste
    {
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("intitule")]
        public string Intitule { get; set; }

        [Range(1, 5)]
        [Column("niveau_hierarchique")]
        public int NiveauHierarchique { get; set; }

        [Column("salaire_min", TypeName = "decimal(18,2)")]
        public decimal SalaireMin { get; set; }

        [Column("salaire_max", TypeName = "decimal(18,2)")]
        public decimal SalaireMax { get; set; }

        // Navigation
        public virtual ICollection<Employe> Employes { get; set; }
    }
}