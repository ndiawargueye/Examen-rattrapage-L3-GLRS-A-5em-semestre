<?php
namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Contrat;
use App\Form\EmployeType;
use App\Form\ContratType;
use App\Repository\EmployeRepository;
use App\Service\EmployeService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employe')]
class EmployeController extends AbstractController
{
    public function __construct(
        private EmployeService         $employeService,
        private EmployeRepository      $employeRepo,
        private EntityManagerInterface $em,
    ) {}

    // ---------- LISTE avec pagination ----------
    #[Route('/', name: 'employe_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $query = $this->employeRepo->findAllQueryBuilder()->getQuery();

        $employes = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10  // 10 par page
        );

        return $this->render('employe/index.html.twig', ['employes' => $employes]);
    }

    // ---------- CREER ----------
    #[Route('/create', name: 'employe_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $employe = new Employe();
        $form    = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->employeService->creerEmploye($employe);
            if ($result->isSuccess()) {
                $this->addFlash('success', 'Employe cree avec succes.');
                return $this->redirectToRoute('employe_index');
            }
            $this->addFlash('danger', $result->getMessage());
        }

        return $this->render('employe/create.html.twig', ['form' => $form->createView()]);
    }

    // ---------- MODIFIER ----------
    #[Route('/{id}/edit', name: 'employe_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request): Response
    {
        $employe = $this->employeRepo->find($id);
        if (!$employe) {
            $this->addFlash('danger', 'Employe introuvable.');
            return $this->redirectToRoute('employe_index');
        }

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Employe mis a jour.');
            return $this->redirectToRoute('employe_index');
        }

        return $this->render('employe/edit.html.twig', [
            'form'    => $form->createView(),
            'employe' => $employe,
        ]);
    }

    // ---------- DETAILS ----------
    #[Route('/{id}', name: 'employe_details', methods: ['GET'])]
    public function details(int $id): Response
    {
        $employe = $this->employeRepo->find($id);
        if (!$employe) {
            $this->addFlash('danger', 'Employe introuvable.');
            return $this->redirectToRoute('employe_index');
        }
        return $this->render('employe/details.html.twig', ['employe' => $employe]);
    }

    // ---------- SUPPRIMER ----------
    #[Route('/{id}/delete', name: 'employe_delete', methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $result = $this->employeService->supprimerEmploye($id);
            if ($result->isSuccess()) {
                $this->addFlash('success', 'Employe supprime.');
            } else {
                $this->addFlash('danger', $result->getMessage());
            }
        }
        return $this->redirectToRoute('employe_index');
    }

    // ---------- AJOUTER CONTRAT ----------
    #[Route('/{id}/contrat', name: 'employe_ajouter_contrat', methods: ['GET', 'POST'])]
    public function ajouterContrat(int $id, Request $request): Response
    {
        $employe = $this->employeRepo->find($id);
        if (!$employe) {
            $this->addFlash('danger', 'Employe introuvable.');
            return $this->redirectToRoute('employe_index');
        }

        $contrat = new Contrat();
        $form    = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->employeService->ajouterContrat($employe, $contrat);
            if ($result->isSuccess()) {
                $this->addFlash('success', 'Contrat ajoute avec succes.');
                return $this->redirectToRoute('employe_details', ['id' => $id]);
            }
            $this->addFlash('danger', $result->getMessage());
        }

        return $this->render('employe/contrat.html.twig', [
            'form'    => $form->createView(),
            'employe' => $employe,
        ]);
    }
}
