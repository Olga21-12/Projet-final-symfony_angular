<?php
namespace App\Controller\Api;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

    #[Route('/api/users', name: 'api_users_')]
class UserController extends AbstractController
{
        // --- GET: tous les utilisateurs ---
    #[Route('', methods: ['GET'])]
        public function index(UserRepository $repo): JsonResponse
    {
        $users = $repo->findAll();
        $data = array_map(fn(User $u) => [
            'id' => $u->getId(),
            'email' => $u->getEmail(),
            'nom' => $u->getNom(),
            'prenom' => $u->getPrenom(),
            'surnom' => $u->getSurnom(),
            'adresse' => $u->getAdresse(),
            'telephone' => $u->getTelephone(),
            'emplacement' => $u->getEmplacement()?->getVille() ?? null,

        ], $users);

        return $this->json($data);
    }

        // --- GET: un utilisateur par id ---
    #[Route('/{id}', methods: ['GET'])]
    public function show(UserRepository $repo, int $id): JsonResponse
    {
        $user = $repo->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $data = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'surnom' => $user->getSurnom(),
            'adresse' => $user->getAdresse(),
            'telephone' => $user->getTelephone(),
            'date_inscription' => $user->getDateInscription()?->format('Y-m-d'),
        ];

        return $this->json($data);
    }

        // --- POST: création d’un utilisateur ---
    #[Route('', methods: ['POST'])]
        public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {

        $body = json_decode($request->getContent(), true);

        // Validation minimale
        if (
            !isset($body['email'], $body['nom'], $body['prenom'], $body['password'])
            || empty($body['email'])
            || empty($body['password'])
        ) {
            return $this->json(['error' => 'Champs manquants ou invalides'], 400);
        }

    // Création d’un nouvel utilisateur
        $user = new User();
        $user->setEmail($body['email']);
        $user->setNom($body['nom']);
        $user->setPrenom($body['prenom']);
        $user->setSurnom($body['surnom'] ?? '');
        $user->setAdresse($body['adresse'] ?? '');
        $user->setTelephone($body['telephone'] ?? null);
        $user->setPassword(password_hash($body['password'], PASSWORD_BCRYPT));
        
        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'Utilisateur créé avec succès',
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
        ], 201);
    }

    // --- PUT: mise à jour d’un utilisateur ---
    #[Route('/{id}', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, UserRepository $repo, EntityManagerInterface $em, int $id): JsonResponse
    {
        $user = $repo->find($id);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $body = json_decode($request->getContent(), true);

        $user->setNom($body['nom'] ?? $user->getNom());
        $user->setPrenom($body['prenom'] ?? $user->getPrenom());
        $user->setSurnom($body['surnom'] ?? $user->getSurnom());
        $user->setAdresse($body['adresse'] ?? $user->getAdresse());
        $user->setTelephone($body['telephone'] ?? $user->getTelephone());
        $user->setDateModification(new \DateTimeImmutable());

        $em->flush();

        return $this->json(['message' => 'Utilisateur mis à jour avec succès']);
    }

    // --- DELETE: suppression d’un utilisateur ---
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(UserRepository $repo, EntityManagerInterface $em, int $id): JsonResponse
    {
        $user = $repo->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $em->remove($user);
        $em->flush();

        return $this->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
