<?php

namespace App\Controller;

<<<<<<< HEAD
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
            'list' => $repo->findAll()
        ]);
    }

    #[Route('/details/{id}', name: 'specialite_details')]
    public function specialiteDetails(Specialite $specialite): Response
    {
        return $this->render('specialite/details.html.twig', [
            'specialite' => $specialite
        ]);
    }

    #[Route('/delete/{id}', name: 'specialite_delete', methods: ['POST'])]
    public function specialiteDelete($id, ManagerRegistry $manager): Response
    {
        $specialite = $manager->getRepository(Specialite::class)->find($id);
        if (!$specialite) {
            throw $this->createNotFoundException("Specialite with ID $id not found.");
        }

        $em = $manager->getManager();
        $em->remove($specialite);
        $em->flush();

        $this->addFlash('success', 'Specialite removed successfully');
        return $this->redirectToRoute('specialite_list');
    }

    #[Route('/add', name: 'specialite_add')]
    public function specialiteAdd(Request $request, ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $specialite = new Specialite();
        
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($specialite);
            $em->flush();
            return $this->redirectToRoute('specialite_list');
        }

        return $this->render('specialite/form.html.twig', ['f' => $form]);
    }

    #[Route('/update/{id}', name: 'specialite_update')]
    public function specialiteUpdate(Request $request, ManagerRegistry $manager, Specialite $specialite): Response
    {
        $em = $manager->getManager();
        
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($specialite);
            $em->flush();
            return $this->redirectToRoute('specialite_list');
        }

        return $this->render('specialite/form.html.twig', ['f' => $form]);
    }
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SpecialiteController extends AbstractController
{
    #[Route('/specialite', name: 'app_specialite')]
    public function index(): Response
    {
        return $this->render('specialite/index.html.twig', [
            'controller_name' => 'SpecialiteController',
        ]);
    }
>>>>>>> origin/travailtayeb
}
