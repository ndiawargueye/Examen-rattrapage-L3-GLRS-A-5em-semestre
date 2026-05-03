using System;
using System.Collections.Generic;
using System.Linq;
using GRH.Data;
using GRH.Models;

namespace GRH.Repositories
{
    public class EmployeRepository 
        : Repository<Employe>, IEmployeRepository
    {
        public EmployeRepository(ApplicationDbContext context)
            : base(context) { }

        public Employe GetByMatricule(string matricule)
            => _dbSet.FirstOrDefault(e => e.Matricule == matricule);

        public Employe GetByEmail(string email)
            => _dbSet.FirstOrDefault(e => e.Email == email);

        public IEnumerable<Employe> GetByDepartement(int departementId)
            => _dbSet.Where(e => e.DepartementId == departementId).ToList();

        public bool HasContratActif(int employeId)
            => _context.Contrats.Any(c =>
                c.EmployeId == employeId &&
                (c.DateFin == null || c.DateFin > DateTime.Now));

        public int GetAncienneteEnMois(int employeId)
        {
            var contrat = _context.Contrats
                .Where(c => c.EmployeId == employeId)
                .OrderBy(c => c.DateDebut)
                .FirstOrDefault();

            if (contrat == null) return 0;

            var diff = DateTime.Now - contrat.DateDebut;
            return (int)(diff.TotalDays / 30);
        }
    }
}