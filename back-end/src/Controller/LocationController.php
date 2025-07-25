<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/locations')]
class LocationController extends AbstractController
{
    #[Route('/nearby', name: 'api_locations_nearby', methods: ['GET'])]
    public function nearby(Request $request, LocationRepository $repo): JsonResponse
    {
        $lat    = (float) $request->query->get('lat');
        $lng    = (float) $request->query->get('lng');
        $radius = (float) $request->query->get('radius', 1.0);

        if (!$lat || !$lng) {
            return $this->json(['error' => 'Coordonnées manquantes'], 400);
        }

        // résultat = tableau associatif (raw SQL)
        $rows = $repo->findNearby($lat, $lng, $radius);

        $data = array_map(static fn(array $r) => [
            'id'        => (int) $r['location_id'],
            'name'      => $r['name'],
            'address'   => $r['address'],
            'city'      => $r['city'],
            'country'   => $r['country'],
            'latitude'  => (float) $r['latitude'],
            'longitude' => (float) $r['longitude'],
            'distance'  => round($r['distance'], 3),   // km
        ], $rows);

        return $this->json($data);
    }
}