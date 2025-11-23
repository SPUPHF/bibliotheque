<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'bibliotheque_home')]
    public function home(): Response
    {
        $user = $this->getUser(); // récupère l'utilisateur connecté

        return $this->render('home.html.twig', [
            'user' => $user,
        ]);
    }
}
