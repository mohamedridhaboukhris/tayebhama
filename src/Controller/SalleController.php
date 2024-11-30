<?php

namespace App\Controller;

use App\Form\EvenementType;
use App\Entity\Evenement;
use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/show_all', name: 'salle_all', methods: ['GET'])]
    public function showAll(SalleRepository $salleRepository): Response
    {
        return $this->render('Mon_salle/salle/show_all.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);
    }

    #[Route('/Salle_new', name: 'salle_new')]

    #[Route('/', name: 'salle_index', methods: ['GET'])]
    public function indexSalle(SalleRepository $salleRepository): Response
    {
        return $this->render('salle/index.html.twig', [
            'salles' => $salleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'salle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salle);
            $entityManager->flush();

            return $this->redirectToRoute('salle_all');
        }

        return $this->render('Mon_salle/salle/new.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter une Nouvelle Salle',
            'message' => 'Veuillez remplir le formulaire ci-dessous pour ajouter une nouvelle salle.'
        ]);
    }

    #[Route('/salle_show/{id}', name: 'salle_show', methods: ['GET'])]
    public function show(?Salle $salle): Response
    {
        if (!$salle) {
            return $this->render('Mon_salle/salle/show.html.twig', [
                'salle' => null,
                'error' => 'La salle demandée n\'existe pas.',
            ]);
        }
        return $this->render('Mon_salle/salle/show.html.twig', [
            'salle' => $salle,
            'error' => null,
        ]);
    }

    #[Route('/Salle_edit/{id}', name: 'salle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Salle modifiée avec succès !');

            return $this->redirectToRoute('salle_all');
        }

        return $this->render('Mon_salle/salle/edit.html.twig', [
            'salle' => $salle,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/salle/search', name: 'salle_search', methods: ['GET', 'POST'])]
    public function search(Request $request, SalleRepository $salleRepository, SessionInterface $session): Response
    {
        $criteria = $request->query->all();

        if ($request->query->get('action') === 'historique') {
            $historique = $session->get('historique_recherche', []);
            return $this->render('Mon_salle/salle/historique.html.twig', [
                'historique' => $historique,
            ]);
        }

        $salles = $salleRepository->findByCriteria($criteria);

        $historique = $session->get('historique_recherche', []);
        if (!empty($criteria)) {
            $historique[] = $criteria;
            $session->set('historique_recherche', $historique);
        }

        if (count($salles) === 1) {
            return $this->redirectToRoute('salle_show', ['id' => $salles[0]->getId()]);
        }

        return $this->render('Mon_salle/salle/search.html.twig', [
            'salle' => $salles[0] ?? null,
            'criteria' => $criteria,
        ]);
    }

    #[Route('/Salle_delete/{id}', name: 'salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $salle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($salle);
            $entityManager->flush();

            $this->addFlash('success', 'Salle supprimée avec succès !');
        }
        return $this->redirectToRoute('salle_all');
    }

    #[Route('/salle/{id}/evenement/new', name: 'evenement_new', methods: ['GET', 'POST'])]
    public function addEvenement(
        Request $request,
        Salle $salle,
        EntityManagerInterface $entityManager,
        EvenementRepository $evenementRepository
    ): Response {
        $evenement = new Evenement();
        $evenement->setSalle($salle);

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conflicts = $evenementRepository->checkAvailability(
                $salle,
                $evenement->getDate(),
                $evenement->getHeureDebut(),
                $evenement->getHeureFin()
            );

            if (!empty($conflicts)) {
                $this->addFlash('error', 'Cette salle est déjà occupée à cette date et heure.');
                return $this->render('Mon_salle/evenement/new.html.twig', [
                    'form' => $form->createView(),
                    'salle' => $salle,
                ]);
            }

            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', 'Événement ajouté avec succès !');
            return $this->redirectToRoute('salle_evenements', ['id' => $salle->getId()]);
        }

        return $this->render('Mon_salle/evenement/new.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle,
        ]);
    }

    #[Route('/salle/{id}/evenements', name: 'salle_evenements', methods: ['GET'])]
    public function listEvenements(Salle $salle): Response
    {
        return $this->render('Mon_salle/evenement/list.html.twig', [
            'salle' => $salle,
            'evenements' => $salle->getEvenements(),
        ]);
    }
    #[Route('/evenement/{id}/edit', name: 'evenement_edit', methods: ['GET', 'POST'])]
public function editEvenement(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(EvenementType::class, $evenement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Événement modifié avec succès !');
        return $this->redirectToRoute('salle_evenements', ['id' => $evenement->getSalle()->getId()]);
    }

    return $this->render('Mon_salle/evenement/edit.html.twig', [
        'form' => $form->createView(),
        'evenement' => $evenement,
    ]);
}
#[Route('/evenement/{id}/delete', name: 'evenement_delete', methods: ['POST'])]
public function deleteEvenement(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
        $entityManager->remove($evenement);
        $entityManager->flush();

        $this->addFlash('success', 'Événement supprimé avec succès !');
    }

    return $this->redirectToRoute('salle_evenements', ['id' => $evenement->getSalle()->getId()]);
}

}
