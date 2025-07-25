<?php

namespace App\Repository;

use App\Entity\FavoriteLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavoriteLocation>
 */
class FavoriteLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteLocation::class);
    }

    /**
     * Récupère les lieux favoris d'un utilisateur donné.
     */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :user')
            ->setParameter('user', $userId)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Vérifie si un lieu est déjà en favori pour un utilisateur.
     */
    public function isLocationFavorited(int $userId, int $locationId): bool
    {
        return (bool) $this->createQueryBuilder('f')
            ->select('1')
            ->andWhere('f.user = :user')
            ->andWhere('f.location = :location')
            ->setParameter('user', $userId)
            ->setParameter('location', $locationId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}