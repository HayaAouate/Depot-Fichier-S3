<?php

namespace App\Controller;

use App\Entity\Candidatures;
use App\Form\CandidaturesType;
use App\Repository\CandidaturesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class CandidaturesController extends AbstractController{

    #[Route('/depot', name: 'app_candidatures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidature = new Candidatures();
        $form = $this->createForm(CandidaturesType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidatures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidatures/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }
}
