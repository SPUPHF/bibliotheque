<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Ouvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Récupère toutes les réservations actives
     *
     * @return Reservation[]
     */
    public function findActiveReservations(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.active = :active')
            ->setParameter('active', true)
            ->orderBy('r.dateCreation', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère la file d’attente des réservations pour un ouvrage donné
     *
     * @param Ouvrage $ouvrage
     * @return Reservation[]
     */
    public function findQueueByOuvrage(Ouvrage $ouvrage): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.ouvrage = :ouvrage')
            ->andWhere('r.active = :active')
            ->setParameter('ouvrage', $ouvrage)
            ->setParameter('active', true)
            ->orderBy('r.dateCreation', 'ASC') // ancienneté = priorité
            ->getQuery()
            ->getResult();
    }

    /**
     * Désactive toutes les réservations expirées ou annulées
     *
     * @return int Nombre de lignes mises à jour
     */
    public function deactivateExpired(): int
    {
        $qb = $this->createQueryBuilder('r')
            ->update()
            ->set('r.active', ':false')
            ->where('r.dateCreation < :dateLimite')
            ->setParameter('false', false)
            ->setParameter('dateLimite', new \DateTimeImmutable('-30 days'));

        return $qb->getQuery()->execute();
    }
}
