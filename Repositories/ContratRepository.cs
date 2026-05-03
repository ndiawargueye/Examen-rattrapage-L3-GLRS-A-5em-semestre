using System;
using System.Collections.Generic;
using System.Linq;
using GRH.Data;
using GRH.Models;

namespace GRH.Repositories
{
    public class ContratRepository 
        : Repository<Contrat>, IContratRepository
    {
        public ContratRepository(ApplicationDbContext context)
            : base(context) { }

        public Contrat GetContratActif(int employeId)
            => _dbSet.FirstOrDefault(c =>
                c.EmployeId == employeId &&
                (c.DateFin == null || c.DateFin > DateTime.Now));

        public IEnumerable<Contrat> GetByEmploye(int employeId)
            => _dbSet.Where(c => c.EmployeId == employeId)
                     .OrderByDescending(c => c.DateDebut)
                     .ToList();

        public void CloturerContrat(int contratId)
        {
            var contrat = _dbSet.Find(contratId);
            if (contrat != null)
            {
                contrat.DateFin = DateTime.Now;
                _context.Entry(contrat).State = 
                    System.Data.Entity.EntityState.Modified;
            }
        }
    }
}
