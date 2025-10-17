<?php
namespace App\Controller\Api;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

    #[Route('/api/users')]
class UserController extends AbstractController
{

    #[Route('', methods: ['GET'])]
        public function index(UserRepository $repo): JsonResponse
    {
        $users = $repo->findAll();
        $data = array_map(fn(User $u) => [
            'id' => $u->getId(),

            'name' => $u->getName(),
            'email' => $u->getEmail(),
            'registeredAt' => $u->getRegisteredAt()->format('Y-m-d'),

        ], $users);

        return $this->json($data);
    }

    #[Route('', methods: ['POST'])]
        public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {

        $body = json_decode($request->getContent(), true);

        if (!isset($body['name'], $body['email'])) {
            return $this->json(['error' => 'Données invalides'], 400);
    }

    $user = new User();
    $user->setName($body['name']);
    $user->setEmail($body['email']);
    $user->setRegisteredAt(new \DateTimeImmutable());
    $em->persist($user);
    $em->flush();

    return $this->json([
    'id' => $user->getId(),
    'name' => $user->getName(),
    'email' => $user->getEmail(),
    'registeredAt' => $user->getRegisteredAt()->format('Y-m-d'),
    ], 201);
    }
}
