<?php
// src/Repository/FavoritePoiRepository.php
namespace App\Repository;

use App\Entity\FavoritePoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FavoritePoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoritePoi::class);
    }

    /** @return FavoritePoi[] */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :u')
            ->setParameter('u', $userId)
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function isPoiFavorited(int $userId, int $poiId): bool
    {
        return (bool) $this->createQueryBuilder('f')
            ->select('1')
            ->andWhere('f.user = :u')
            ->andWhere('f.poi = :p')
            ->setParameter('u', $userId)
            ->setParameter('p', $poiId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}