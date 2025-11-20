<?php


namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    // Tu pourras ajouter des méthodes personnalisées plus tard si besoin
    // Exemple : rechercher les emprunts en retard
    /*
    public function findRetards()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.dateRetourPrevu < :today')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }
    */
}
