<?php

namespace App\Controller;
use App\Entity\Exam;
use App\Repository\ExamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
class ExamController extends AbstractController
{
    #[Route('/exam', name: 'app_exam')]
    public function index(): Response
    {
        return $this->render('exam/index.html.twig', [
            'controller_name' => 'ExamController',
        ]);
    }
    #[Route('/listDB', name: 'exam_listDB')]
    public function listDB(ManagerRegistry $doctrine):response{
$rep = $doctrine->getRepository(Exam::class);
$list = $rep->findAll();
return $this->render('exam/listDB.html.twig',["list"=> $list]);
    }
    #[Route('/delete/{id}', name: 'exam_delete')]

    public function deleteExam($id,ManagerRegistry $manager ,ExamRepository $repo): Response{
        $exam = $repo->find($id);
        $em =$manager->getManager();
        $em->remove($exam);
        $em->flush();
        return $this->redirectToRoute("exam_listDB");}
}
