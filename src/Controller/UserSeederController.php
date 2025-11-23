<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSeederController extends AbstractController
{
    #[Route('/seed-users', name: 'seed_users')]
    public function seed(EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        // Vérifie si les utilisateurs existent déjà
        $existing = $em->getRepository(User::class)->findAll();
        if (count($existing) > 1) {
            return new Response('Les utilisateurs existent déjà.');
        }

        // ---------------- Membre ----------------
        $member = new User();
        $member->setEmail('membre@example.com');
        $member->setNom('Dupont');
        $member->setPrenom('Jean');
        $member->setRoles(['ROLE_MEMBER']);
        $member->setPassword($hasher->hashPassword($member, 'motdepasse123'));
        $member->setDateInscription(new \DateTime());
        $em->persist($member);

        // ---------------- Bibliothécaire ----------------
        $librarian = new User();
        $librarian->setEmail('biblio@example.com');
        $librarian->setNom('Martin');
        $librarian->setPrenom('Claire');
        $librarian->setRoles(['ROLE_LIBRARIAN']);
        $librarian->setPassword($hasher->hashPassword($librarian, 'motdepasse123'));
        $librarian->setDateInscription(new \DateTime());
        $em->persist($librarian);

        $em->flush();

        return new Response('Membre et bibliothécaire ajoutés avec succès !');
    }
}
