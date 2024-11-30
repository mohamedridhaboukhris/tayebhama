<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/list', name: 'cours_listDB', methods: ['GET'])]
    public function listDB(ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Cours::class);
        $list = $rep->findAll();
        return $this->render('cours/list_cours.html.twig', ["list" => $list]);
    }

    #[Route('/new', name: 'cours_add', methods: ['GET', 'POST'])]
    public function addCours(ManagerRegistry $manager, Request $req): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Cours ajouté avec succès !');
            return $this->redirectToRoute('cours_listDB');
        }

        return $this->render('cours/add_cours.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cours): Response
    {
        return $this->render('cours/show.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Cours modifié avec succès !');
            return $this->redirectToRoute('app_cours_index');
        }

        return $this->render('cours/edit.html.twig', [
            'cours' => $cours,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'cours_delete', methods: ['POST'])]
    public function delete(int $id, ManagerRegistry $manager, CoursRepository $repo): Response
    {
        $cours = $repo->find($id);

        if (!$cours) {
            throw $this->createNotFoundException("Cours avec l'ID $id non trouvé.");
        }

        $em = $manager->getManager();
        $em->remove($cours);
        $em->flush();

        $this->addFlash('success', 'Cours supprimé avec succès !');
        return $this->redirectToRoute("cours_listDB");
    }

    #[Route('/{id}/delete', name: 'app_cours_delete', methods: ['POST'])]
    public function deleteWithToken(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cours->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cours);
            $entityManager->flush();

            $this->addFlash('success', 'Cours supprimé avec succès !');
        }

        return $this->redirectToRoute('app_cours_index');
    }
}
