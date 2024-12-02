<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


#[Route('/exercice')]
final class ExerciceController extends AbstractController{
    #[Route(name: 'app_exercice_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercice::class)
            ->findAll();

        return $this->render('exercice/index.html.twig', [
            'exercices' => $exercices,
        ]);
    }

    #[Route('/new', name: 'app_exercice_new', methods: ['GET', 'POST'])]
    public function indexl(
        Request $request,
        EntityManagerInterface $entityManager,
        #[Autowire('photo_dir')] string $photoDir // Autowire for image upload directory
    ): Response {
        // Fetch all exercices
        $exercices = $entityManager->getRepository(Exercice::class)->findAll();

        // Create a new Exercice entity and form
        $newExercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $newExercice);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded image
            $image_exercice = $form['image_exercice']->getData();

            // If an image was uploaded, move it to the specified directory
            if ($image_exercice) {
                $newFilename = uniqid() . '.' . $image_exercice->guessExtension(); // Generate a unique filename
                $image_exercice->move($photoDir, $newFilename); // Move the file to the upload directory

                // Set the filename in the Exercice entity
                $newExercice->setImageExercice($newFilename);
            }

            // Persist the new Exercice entity
            $entityManager->persist($newExercice);
            $entityManager->flush();

            // Redirect to the exercices index page after creation
            return $this->redirectToRoute('app_exercice_index');
        }

        // Render the form for creating a new Exercice
        return $this->render('exercice/new.html.twig', [
            'exercices' => $exercices,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/{id}', name: 'app_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice): Response
    {
        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercice_delete', methods: ['POST'])]
    public function delete(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
}
