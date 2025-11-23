<?php

namespace App\Controller;

use App\Entity\Exemplaire;
use App\Form\ExemplaireType;
use App\Repository\ExemplaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/exemplaire')]
final class ExemplaireController extends AbstractController
{
    #[Route('/', name: 'app_exemplaire_index', methods: ['GET'])]
    public function index(ExemplaireRepository $exemplaireRepository): Response
    {
        $exemplaires = $exemplaireRepository->findAll();

        return $this->render('exemplaire/index.html.twig', [
            'exemplaires' => $exemplaires,
        ]);
    }

    #[Route('/new', name: 'app_exemplaire_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $exemplaire = new Exemplaire();
        $form = $this->createForm(ExemplaireType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($exemplaire);
            $em->flush();

            return $this->redirectToRoute('app_exemplaire_index');
        }

        return $this->render('exemplaire/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exemplaire_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function edit(Request $request, Exemplaire $exemplaire, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ExemplaireType::class, $exemplaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_exemplaire_index');
        }

        return $this->render('exemplaire/edit.html.twig', [
            'form' => $form->createView(),
            'exemplaire' => $exemplaire,
        ]);
    }

    #[Route('/{id}', name: 'app_exemplaire_delete', methods: ['POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function delete(Request $request, Exemplaire $exemplaire, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exemplaire->getId(), $request->request->get('_token'))) {
            $em->remove($exemplaire);
            $em->flush();
        }

        return $this->redirectToRoute('app_exemplaire_index');
    }
}
