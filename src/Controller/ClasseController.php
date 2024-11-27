<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Form\ClasseType;
use App\Form\EtudiantType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    #[Route('/list-class', name: 'classe_list')]
    public function classeList(ClasseRepository $repo): Response
    {
        $class = $repo->findAll();
        return $this->render('classe/class.list.html.twig', [
            'list' => $class,
        ]);
    }

    #[Route('/delete/{id}', name: 'classe_delete', methods: ['POST'])]
    public function classeDelete($id, ManagerRegistry $manager): Response
    {
        $classe = $manager->getRepository(Classe::class)->find($id);
        if (!$classe) {
            throw $this->createNotFoundException("Classe with ID $id not found.");
        }

        $em = $manager->getManager();
        $em->remove($classe);
        $em->flush();

        $this->addFlash('success', 'Classe removed successfully');
        return $this->redirectToRoute('classe_list');
    }

    #[Route('/class/add', name: 'classe_add')]
    public function classeAdd(Request $request, ManagerRegistry $manager): Response
    {
        $classe = new Classe(); 
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($classe);
            $em->flush();
    
            $this->addFlash('success', 'La classe a été ajoutée avec succès !');
            return $this->redirectToRoute('classe_list');
        }
    
        return $this->render('classe/addclass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'classe_update')]
    public function classeUpdate(Request $request, ManagerRegistry $manager, Classe $classe): Response
    {
        $em = $manager->getManager();
        
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute('classe_list');
        }

        return $this->render('classe/addclass.html.twig', ['form' => $form]);
    }

    #[Route('/etudiant/add/{classe_id}', name: 'etudiant_add')]
    public function addEtudiant(Request $request, ManagerRegistry $manager, ClasseRepository $classeRepo, $classe_id): Response
    {
        $classe = $classeRepo->find($classe_id);

        if (!$classe) {
            throw $this->createNotFoundException('Classe non trouvée');
        }

        $etudiant = new Etudiant();
        $etudiant->setClasse($classe);

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('classe_details', ['id' => $classe->getId()]);
        }

        return $this->render('classe/add.html.twig', [
            'form' => $form->createView(),
            'classe' => $classe,
        ]);
    }

    #[Route('/etudiant/delete/{id}', name: 'etudiant_delete', methods: ['POST'])]
    public function deleteEtudiant(int $id, ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $etudiant = $em->getRepository(Etudiant::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException('Étudiant non trouvé.');
        }

        $classeId = $etudiant->getClasse()->getId();
        $em->remove($etudiant);
        $em->flush();

        return $this->redirectToRoute('classe_details', ['id' => $classeId]);
    }

    #[Route('/classe/details/{id}', name: 'classe_details')]
public function classeDetail(Classe $classe): Response
{
    // Vérifiez si la classe est vide
    if ($classe->getEtudiants()->isEmpty()) {
        $status = 'vide'; // État si la classe n'a pas d'étudiants
    } else {
        // Sinon, calculez l'état en fonction de l'heure
        $currentHour = (int)(new \DateTime())->format('H');
        $currentMinute = (int)(new \DateTime())->format('i');

        if (($currentHour >= 8 && $currentHour < 12) || ($currentHour == 12 && $currentMinute == 0)) {
            $status = 'cours';
        } elseif (($currentHour == 12 && $currentMinute > 0) || ($currentHour == 13 && $currentMinute <= 30)) {
            $status = 'pause';
        } elseif ($currentHour >= 13 && $currentHour < 17) {
            $status = 'cours';
        } else {
            $status = 'fin';
        }
    }

    return $this->render('classe/details.html.twig', [
        'classe' => $classe,
        'status' => $status,
    ]);
}

    #[Route('/etudiant/details/{id}', name: 'etudiant_details')]
    public function details(Etudiant $etudiant): Response
    {
        return $this->render('classe/details.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }
}
