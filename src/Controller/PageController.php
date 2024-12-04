<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Examen;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/dash', name: 'app_dash')]
    public function dash(): Response
    {
        return $this->render('page/dash.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/examshow',name: 'app_examen_user')]
    public function indexcx(EntityManagerInterface $entityManager): Response
    {
        $today = new \DateTime('today');

        $examens = $entityManager->getRepository(Examen::class)->createQueryBuilder('e')
            ->where('e.date <= :today')
            ->setParameter('today', $today)
            ->getQuery()
            ->getResult();

        return $this->render('examen/showusser.html.twig', [
            'examens' => $examens,
        ]);
    }
    #[Route('/examshow/{id}',name: 'app_examen_usershow')]

    public function show(Examen $examen): Response
    {
        // Fetch the exercices associated with the Examen
        // Assuming you have a relationship between Examen and Exercice entities
        $exercices = $examen->getExercices();  // Assuming getExercices() is a method in Examen entity

        return $this->render('examen/showdeails.html.twig', [
            'examen' => $examen,
            'exercices' => $exercices,
        ]);
    }
    #[Route('/coursshow', name: 'app_cours_user')]
    public function indexCours(CoursRepository $rep): Response
    {

        $cours = $rep->findAll();

        return $this->render('cours/showuser.html.twig', [
            'cours' => $cours,
        ]);
    }
    #[Route('/coursdet/{id}', name: 'app_cours_showdet')]
    public function showCours(Cours $cours): Response
    {
        // Récupérer les chapitres associés au cours
        $chapitres = $cours->getChapitres();

        return $this->render('cours/showdetails.html.twig', [
            'cours' => $cours,
            'chapitres' => $chapitres,
        ]);
    }


}
