<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/emprunt')]
final class EmpruntController extends AbstractController
{
    #[Route('/', name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        $user = $this->getUser();

        if (in_array('ROLE_MEMBER', $user->getRoles())) {
            // Les membres ne voient que leurs propres emprunts
            $emprunts = $empruntRepository->findBy(['user' => $user]);
        } else {
            // Librarian/Admin voient tous les emprunts
            $emprunts = $empruntRepository->findAll();
        }

        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    #[Route('/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($emprunt);
            $em->flush();

            return $this->redirectToRoute('app_emprunt_index');
        }

        return $this->render('emprunt/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emprunt_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function edit(Request $request, Emprunt $emprunt, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_emprunt_index');
        }

        return $this->render('emprunt/edit.html.twig', [
            'form' => $form->createView(),
            'emprunt' => $emprunt,
        ]);
    }

    #[Route('/{id}', name: 'app_emprunt_delete', methods: ['POST'])]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $emprunt->getId(), $request->request->get('_token'))) {
            $em->remove($emprunt);
            $em->flush();
        }

        return $this->redirectToRoute('app_emprunt_index');
    }

    #[Route('/{id}', name: 'app_emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }
}
