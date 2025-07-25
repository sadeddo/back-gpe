<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $jwt
    ): JsonResponse {
        $d = json_decode($request->getContent(), true);

        if (empty($d['username']) || empty($d['email']) || empty($d['password'])) {
            return $this->json(['message' => 'Champs obligatoires manquants : username, email, password.'], 400);
        }

        $user = (new User())
            ->setFirstName($d['first_name'] ?? null)
            ->setLastName($d['last_name'] ?? null)
            ->setUsername($d['username'])
            ->setEmail($d['email'])
            ->setPassword($hasher->hashPassword(new User(), $d['password']))
            ->setIsActive(true);

        if ($role = $em->getRepository(Role::class)->findOneBy(['roleName' => 'ROLE_USER'])) {
            $user->addRole($role);
        }

        try {
            $em->persist($user);
            $em->flush();
        } catch (UniqueConstraintViolationException) {
            return $this->json(['message' => 'E-mail ou nom d’utilisateur déjà utilisé.'], 409);
        }

        return $this->json([
            'token' => $jwt->create($user),
            'user'  => [
                'id'       => $user->getId(),
                'username' => $user->getUsername(),
                'email'    => $user->getEmail(),
            ],
        ]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $jwt
    ): JsonResponse {
        $d = json_decode($request->getContent(), true);

        if (empty($d['password'])) {
            return $this->json(['message' => 'Mot de passe requis.'], 400);
        }

        if (!empty($d['email'])) {
            $user = $em->getRepository(User::class)->findOneBy(['email' => $d['email']]);
        } elseif (!empty($d['username'])) {
            $user = $em->getRepository(User::class)->findOneBy(['username' => $d['username']]);
        } else {
            return $this->json(['message' => 'Veuillez fournir soit un email, soit un username.'], 400);
        }

        if (!$user || !$hasher->isPasswordValid($user, $d['password'])) {
            return $this->json(['message' => 'Identifiants invalides.'], 401);
        }

        return $this->json([
            'token' => $jwt->create($user),
            'user'  => [
                'id'       => $user->getId(),
                'username' => $user->getUsername(),
                'email'    => $user->getEmail(),
            ],
        ]);
    }

    #[Route('/api/guest', name: 'api_guest', methods: ['POST'])]
    public function guest(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $jwt
    ): JsonResponse {
        $guest = (new User())
            ->setFirstName('Invité')->setLastName('')
            ->setUsername('guest_' . uniqid())
            ->setEmail('guest_' . uniqid() . '@navzen.local')
            ->setPassword($hasher->hashPassword(new User(), 'guest'))
            ->setIsActive(true);

        if ($role = $em->getRepository(Role::class)->findOneBy(['roleName' => 'ROLE_GUEST'])) {
            $guest->addRole($role);
        }

        $em->persist($guest);
        $em->flush();

        return $this->json([
            'token' => $jwt->create($guest),
            'user'  => [
                'id'       => $guest->getId(),
                'username' => $guest->getUsername(),
                'email'    => $guest->getEmail(),
            ],
        ]);
    }
}