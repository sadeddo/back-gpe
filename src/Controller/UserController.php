<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\LocationRepository;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/me', name: 'get_me', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getMe(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json([
            'id'                  => $user->getId(),
            'name'                => $user->getName(),
            'username'            => $user->getUsername(),
            'email'               => $user->getEmail(),
            'phone'               => $user->getPhoneNumber(),
            'address'             => $user->getAddress(),
            'roles'               => $user->getRoles(),
            'created_at'          => $user->getCreatedAt()?->format(DATE_ATOM),
            'profile_picture_url' => $user->getProfilePictureUrl(),
        ]);
    }

    #[Route('/me', name: 'update_me', methods: ['PUT'])]
    #[IsGranted('ROLE_USER')]
    public function updateMe(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        /** @var User $user */
        $user = $this->getUser();
        $d = json_decode($request->getContent(), true);

        if (isset($d['name'])) {
            $parts = preg_split('/\s+/', trim($d['name']));
            $first = array_shift($parts);
            $last  = implode(' ', $parts);
            $user->setFirstName($first)->setLastName($last);
        }

        if (isset($d['username']))             { $user->setUsername($d['username']); }
        if (isset($d['email']))                { $user->setEmail($d['email']); }
        if (!empty($d['password']))            { $user->setPassword($hasher->hashPassword($user, $d['password'])); }
        if (isset($d['phone']))                { $user->setPhoneNumber($d['phone']); }
        if (isset($d['address']))              { $user->setAddress($d['address']); }
        if (array_key_exists('profile_picture_url', $d)) {  $user->setProfilePictureUrl($d['profile_picture_url']); }
        

        $em->flush();

        return $this->json(['message' => 'Profil mis à jour avec succès.']);
    }

    #[Route('/me', name: 'delete_me', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function deleteMe(EntityManagerInterface $em): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $em->remove($user);
        $em->flush();

        return $this->json(['message' => 'Compte supprimé.']);
    }
#[Route('/test-location', name: 'test_location', methods: ['GET'])]
public function testLocation(LocationRepository $repo): JsonResponse
{
    $lat = 48.8064;
    $lng = 2.5330;
    $radius = 5;

    $results = $repo->findNearby($lat, $lng, $radius);
    return $this->json($results);
}
}