<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/specialite')]
class SpecialiteController extends AbstractController
{
    #[Route('/list', name: 'specialite_list')]
    public function specialiteList(SpecialiteRepository $repo): Response
    {
        return $this->render('specialite/list.html.twig', [
            'list' => $repo->findAll(),
        ]);
    }

    #[Route('/details/{id}', name: 'specialite_details')]
    public function specialiteDetails(Specialite $specialite): Response
    {
        return $this->render('specialite/details.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    #[Route('/delete/{id}', name: 'specialite_delete', methods: ['POST'])]
    public function specialiteDelete($id, ManagerRegistry $manager): Response
    {
        $specialite = $manager->getRepository(Specialite::class)->find($id);

        if (!$specialite) {
            throw $this->createNotFoundException("Spécialité avec l'ID $id non trouvée.");
        }

        $em = $manager->getManager();
        $em->remove($specialite);
        $em->flush();

        $this->addFlash('success', 'Spécialité supprimée avec succès.');
        return $this->redirectToRoute('specialite_list');
    }
/*
    #[Route('/add', name: 'specialite_add')]
    public function specialiteAdd(Request $request, ManagerRegistry $manager): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($specialite);
            $em->flush();

            $this->addFlash('success', 'Spécialité ajoutée avec succès.');
            return $this->redirectToRoute('specialite_list');
        }

        return $this->render('specialite/form.html.twig', ['f' => $form->createView()]);
    }

   /* #[Route('/update/{id}', name: 'specialite_update')]
    public function specialiteUpdate(Request $request, ManagerRegistry $manager, Specialite $specialite): Response
    {
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($specialite);
            $em->flush();

            $this->addFlash('success', 'Spécialité mise à jour avec succès.');
            return $this->redirectToRoute('specialite_list');
        }

        return $this->render('specialite/form.html.twig', ['f' => $form->createView()]);
    }

    #[Route('/', name: 'app_specialite')]
    public function index(): Response
    {
        return $this->render('specialite/index.html.twig', [
            'controller_name' => 'SpecialiteController',
        ]);
    }
        */
}
