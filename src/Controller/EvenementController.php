<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Salle;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    /**
     * Liste des événements par salle avec regroupement par étiquettes
     */
    #[Route('/', name: 'evenement_list', methods: ['GET'])]
    public function list(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findAll();
    
        return $this->render('evenement/list.html.twig', [
            'evenements' => $evenements, // Transmet tous les événements
        ]);
    }
    
    /**
     * Ajouter un nouvel événement
     */
    #[Route('/new', name: 'evenement_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SalleRepository $salleRepository
    ): Response {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', 'Événement ajouté avec succès !');
            return $this->redirectToRoute('evenement_list');
        }

        return $this->render('evenement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifier un événement existant
     */
    #[Route('/{id}/edit', name: 'evenement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Événement modifié avec succès !');
            return $this->redirectToRoute('evenement_list');
        }

        return $this->render('evenement/edit.html.twig', [
            'form' => $form->createView(),
            'evenement' => $evenement,
        ]);
    }
    #[Route('/{id}/delete', name: 'evenement_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
    
            $this->addFlash('success', 'Événement supprimé avec succès !');
        }
    
        return $this->redirectToRoute('evenement_list');
    }
    

}
