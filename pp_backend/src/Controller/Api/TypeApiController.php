<?php

namespace App\Controller\Api;

use App\Entity\TypesDeBien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/types', name: 'api_types_')]
class TypeApiController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $types = $em->getRepository(TypesDeBien::class)->findAll();
        $data = array_map(fn(TypesDeBien $t) => [
            'id' => $t->getId(),
            'name' => $t->getTypeDeBien(),
        ], $types);

        return $this->json($data);
    }
}
