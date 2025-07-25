<?php
// src/Controller/PoiController.php
namespace App\Controller;

use App\Repository\PoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/locations/{id}/pois', methods: ['GET'])]
class PoiController extends AbstractController
{
    #[Route('', name: 'get_location_pois')]
    public function list(int $id, PoiRepository $repo): JsonResponse
    {
        $pois = $repo->findByLocation($id);

        $data = array_map(fn($p) => [
            'id'            => $p->getId(),
            'name'          => $p->getName(),
            'description'   => $p->getDescription(),
            'type'          => $p->getType(),
            'category'      => $p->getCategory(),
            'latitude'      => $p->getLatitude(),
            'longitude'     => $p->getLongitude(),
            'is_accessible' => $p->isAccessible(),
            'opening_hours' => $p->getOpeningHours(),
            'closing_soon'  => $p->isClosingSoon(),
            'location_id'   => $p->getLocation()->getId(),
            'floor_number'  => $p->getFloor()?->getNumber(),
            'floor_label'   => $p->getFloor()?->getLabel(),
        ], $pois);

        return $this->json($data);
    }
}