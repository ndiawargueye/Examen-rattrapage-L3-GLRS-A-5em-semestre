using System.Collections.Generic;
using GRH.Models;

namespace GRH.Repositories
{
    public interface IContratRepository : IRepository<Contrat>
    {
        Contrat              GetContratActif(int employeId);
        IEnumerable<Contrat> GetByEmploye(int employeId);
        void                 CloturerContrat(int contratId);
    }
}