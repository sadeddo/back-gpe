<?php
// src/Controller/FavoritePoiController.php
namespace App\Controller;

use App\Entity\FavoritePoi;
use App\Repository\FavoritePoiRepository;
use App\Repository\PoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/favorites/pois')]
class FavoritePoiController extends AbstractController
{
    /* ─────────────────────────────── LISTE ─────────────────────────────── */

    #[Route('', name: 'get_user_favorite_pois', methods: ['GET'])]
    public function list(FavoritePoiRepository $repo): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non authentifié'], 401);
        }

        $favorites = $repo->findByUser($user->getId());

        $data = array_map(static function (FavoritePoi $f) {
            $poi       = $f->getPoi();
            $location  = $poi->getLocation();          // relation présente sur Poi

            return [
                'id'        => $f->getId(),
                'poi'       => [
                    'id'          => $poi->getId(),
                    'name'        => $poi->getName(),
                    'description' => $poi->getDescription(),
                    'type'        => $poi->getType(),
                    'category'    => $poi->getCategory(),
                    'floor' => $poi->getFloor()?->getNumber(),
                ],
                /* 👉 Infos de bâtiment ajoutées */
                'location_id'   => $location->getId(),
                'location_name' => $location->getName(),

                'createdAt'     => $f->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $favorites);

        return $this->json($data);
    }

    /* ─────────────────────────────── AJOUT ─────────────────────────────── */

    #[Route('', name: 'add_favorite_poi', methods: ['POST'])]
    public function add(
        Request $request,
        PoiRepository $poiRepo,
        FavoritePoiRepository $favRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non authentifié'], 401);
        }

        $poiId = $request->toArray()['poi_id'] ?? null;
        $poi   = $poiId ? $poiRepo->find($poiId) : null;

        if (!$poi) {
            return $this->json(['error' => 'POI introuvable'], 404);
        }
        if ($favRepo->isPoiFavorited($user->getId(), $poiId)) {
            return $this->json(['message' => 'Déjà en favori'], 200);
        }

        $favorite = (new FavoritePoi())
            ->setUser($user)
            ->setPoi($poi);

        $em->persist($favorite);
        $em->flush();

        return $this->json(
            ['message' => 'Ajouté aux favoris', 'id' => $favorite->getId()],
            201
        );
    }

    /* ───────────────────────────── SUPPRESSION ─────────────────────────── */

    #[Route('/{id}', name: 'remove_favorite_poi', methods: ['DELETE'])]
    public function remove(
        int $id,
        FavoritePoiRepository $repo,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUser();
        $fav  = $repo->find($id);

        if (!$user || !$fav || $fav->getUser() !== $user) {
            return $this->json(['error' => 'Favori introuvable'], 404);
        }

        $em->remove($fav);
        $em->flush();

        return $this->json(['message' => 'Supprimé des favoris']);
    }
}