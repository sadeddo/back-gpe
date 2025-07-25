<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class LocationRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Location::class);
        $this->logger = $logger;
    }
    
    public function findNearby(float $lat, float $lng, float $radiusKm = 1.0): array
    {
        $this->logger->info('🔍 Recherche de bâtiments à proximité', [
            'latitude' => $lat,
            'longitude' => $lng,
            'rayon_km' => $radiusKm
        ]);

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM (
                SELECT *,
                    (6371 * acos(
                        cos(radians(:lat)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(:lng)) +
                        sin(radians(:lat)) *
                        sin(radians(latitude))
                    )) AS distance
                FROM locations
                WHERE latitude IS NOT NULL AND longitude IS NOT NULL
            ) AS calculated
            WHERE distance <= :radius
            ORDER BY distance ASC
        ';

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindValue('lat', $lat);
            $stmt->bindValue('lng', $lng);
            $stmt->bindValue('radius', $radiusKm);
            $result = $stmt->executeQuery();
            $rows = $result->fetchAllAssociative();

            $this->logger->info('📦 Bâtiments trouvés', [
                'count' => count($rows)
            ]);

            return $rows;
        } catch (\Throwable $e) {
            $this->logger->error('❌ Erreur SQL dans findNearby', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }
}