<?php

namespace App\Controller;

use App\Entity\Vocabulary;
use App\Form\VocabularyType;
use App\Repository\VocabularyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vocabulary/edit')]
class VocabularyEditController extends AbstractController
{
    #[Route('/', name: 'app_vocabulary_edit_index', methods: ['GET'])]
    public function index(VocabularyRepository $vocabularyRepository): Response
    {
        return $this->render('vocabulary_edit/index.html.twig', [
            'vocabularies' => $vocabularyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vocabulary_edit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vocabulary = new Vocabulary();
        $form = $this->createForm(VocabularyType::class, $vocabulary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vocabulary);
            $entityManager->flush();

            return $this->redirectToRoute('app_vocabulary_edit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vocabulary_edit/new.html.twig', [
            'vocabulary' => $vocabulary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vocabulary_edit_show', methods: ['GET'])]
    public function show(Vocabulary $vocabulary): Response
    {
        return $this->render('vocabulary_edit/show.html.twig', [
            'vocabulary' => $vocabulary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vocabulary_edit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vocabulary $vocabulary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VocabularyType::class, $vocabulary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vocabulary_edit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vocabulary_edit/edit.html.twig', [
            'vocabulary' => $vocabulary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vocabulary_edit_delete', methods: ['POST'])]
    public function delete(Request $request, Vocabulary $vocabulary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vocabulary->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vocabulary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vocabulary_edit_index', [], Response::HTTP_SEE_OTHER);
    }
}
