<?php

namespace App\Repository;

use App\Entity\Ouvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OuvrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ouvrage::class);
    }

    /**
     * Recherche par titre uniquement
     */
    public function searchByTitre(?string $titre): array
    {
        $qb = $this->createQueryBuilder('o');

        // Si un titre est fourni, on filtre
        if ($titre && trim($titre) !== '') {
            $qb->andWhere('o.titre LIKE :titre')
                ->setParameter('titre', '%' . $titre . '%');
        }

        // Tri par titre
        $qb->orderBy('o.titre', 'ASC');

        return $qb->getQuery()->getResult();
    }
}