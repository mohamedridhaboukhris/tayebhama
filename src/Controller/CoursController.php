<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route('/listcours', name: 'cours_listDB')]
    public function listDB(ManagerRegistry $doctrine):response{
$rep = $doctrine->getRepository(Cours::class);
$list = $rep->findAll();
return $this->render('cours/list_cours.html.twig',["list"=> $list]);
    }


    #[Route('/add_cours', name: 'cours_add')]
    public function addExamen(ManagerRegistry $manager,Request $req):Response{
        $cours = new Cours();
        $em =$manager->getManager();
     $form = $this->createForm(CoursType::class,$cours);
     $form->handleRequest($req);
     if($form->isSubmitted()){
        
        $em->persist($cours);
        $em->flush();
        return $this->redirectToRoute('cours_listDB');
    } 
        
        return $this->render('cours/add_cours.html.twig',['f'=>$form]);
    }    

    #[Route('/delete/{id}', name: 'cours_delete')]

    public function deleteExam($id,ManagerRegistry $manager ,CoursRepository $repo): Response{
        $cours = $repo->find($id);
        $em =$manager->getManager();
        $em->remove($cours);
        $em->flush();
        return $this->redirectToRoute("cours_listDB");}
}
