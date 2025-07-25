<?php
namespace App\Repository;

use App\Entity\Poi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poi::class);
    }

    /**
     * Retourne tous les POIs d’un lieu donné.
     * @return Poi[]
     */
    public function findByLocation(int $locationId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.location = :loc')
            ->setParameter('loc', $locationId)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}