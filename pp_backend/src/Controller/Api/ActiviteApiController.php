<?php

namespace App\Controller\Api;

use App\Entity\TypesActivite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/activites', name: 'api_activites_')]

class ActiviteApiController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $activites = $em->getRepository(TypesActivite::class)->findAll();
        $data = array_map(fn(TypesActivite $a) => [
            'id' => $a->getId(),
            'name' => $a->getTypeActivite(),
        ], $activites);

        return $this->json($data);
    }
}
