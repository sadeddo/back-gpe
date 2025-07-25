<?php

namespace App\Controller;

use App\Entity\FavoriteLocation;
use App\Repository\FavoriteLocationRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favorites/locations')]
class FavoriteLocationController extends AbstractController
{
    #[Route('', name: 'get_user_favorites', methods: ['GET'])]
    public function list(FavoriteLocationRepository $repo): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non authentifié'], 401);
        }

        $favorites = $repo->findByUser($user->getId());

        return $this->json(array_map(static fn(FavoriteLocation $fav) => [
            'id'       => $fav->getId(),
            'location' => [
                'id'      => $fav->getLocation()->getId(),
                'name'    => $fav->getLocation()->getName(),
                'address' => $fav->getLocation()->getAddress(),
                'city'    => $fav->getLocation()->getCity(),
                'country' => $fav->getLocation()->getCountry(),
            ],
            'createdAt' => $fav->getCreatedAt()->format('Y-m-d H:i:s'),
        ], $favorites));
    }

    #[Route('', name: 'add_favorite_location', methods: ['POST'])]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        LocationRepository $locRepo,
        FavoriteLocationRepository $favRepo
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non authentifié'], 401);
        }

        /* Accepte JSON ou FormData */
        $data       = $request->toArray();                 // Symfony ≥5.3
        $locationId = $data['location_id'] ?? null;

        if (!$locationId) {
            return $this->json(['error' => 'location_id manquant'], 400);
        }

        $location = $locRepo->find($locationId) ?? null;
        if (!$location) {
            return $this->json(['error' => 'Lieu introuvable'], 404);
        }

        /* Déjà en favori ? */
        if ($favRepo->isLocationFavorited($user->getId(), $locationId)) {
            return $this->json(['message' => 'Déjà en favori'], 200);
        }

        $favorite = (new FavoriteLocation())
            ->setUser($user)
            ->setLocation($location);

        $em->persist($favorite);
        $em->flush();

        return $this->json(
            ['message' => 'Ajouté aux favoris', 'id' => $favorite->getId()],
            201
        );
    }

    #[Route('/{id}', name: 'remove_favorite_location', methods: ['DELETE'])]
    public function remove(
        int $id,
        FavoriteLocationRepository $repo,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non authentifié'], 401);
        }

        $favorite = $repo->find($id);
        if (!$favorite || $favorite->getUser() !== $user) {
            return $this->json(['error' => 'Favori introuvable'], 404);
        }

        $em->remove($favorite);
        $em->flush();

        return $this->json(['message' => 'Supprimé des favoris']);
    }
}