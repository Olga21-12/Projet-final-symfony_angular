<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Entity\User;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api', name: 'api_')]
class LoginApiController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['error' => 'Email et mot de passe requis.'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé.'], 404);
        }

        if (!$hasher->isPasswordValid($user, $password)) {
            return $this->json(['error' => 'Mot de passe incorrect.'], 401);
        }

        // 🔹 Если всё хорошо
        return $this->json([
            'status' => 'success',
            'message' => 'Connexion réussie !',
            'user' => [
                'id' => $user->getId(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'role' => $user->getRoleName(),
                'surnom' => $user->getSurnom(),
            'adresse' => $user->getAdresse(),
            'telephone' => $user->getTelephone(),
            'date_inscription' => $user->getDateInscription()?->format('Y-m-d')
            ]
        ]);
    }
}
