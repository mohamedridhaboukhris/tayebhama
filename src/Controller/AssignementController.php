<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AssignementController extends AbstractController
{
    #[Route('/assignement', name: 'app_assignement')]
    public function index(): Response
    {
        return $this->render('assignement/index.html.twig', [
            'controller_name' => 'AssignementController',
        ]);
    }
}
