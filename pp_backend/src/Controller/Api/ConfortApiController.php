<?php

namespace App\Controller\Api;

use App\Entity\Confort;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/conforts', name: 'api_conforts_')]
class ConfortApiController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $conforts = $em->getRepository(Confort::class)->findAll();
        $data = array_map(fn(Confort $c) => [
            'id' => $c->getId(),
            'name' => $c->getName(),
        ], $conforts);

        return $this->json($data);
    }
}


