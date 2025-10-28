<?php

namespace App\Controller\Api;

use App\Repository\RechercheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/recherches', name: 'api_recherches_')]
class RechercheApiController extends AbstractController
{
    #[Route('', name: 'user_list', methods: ['GET'])]
    public function list(RechercheRepository $rechercheRepo): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $recherches = $rechercheRepo->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC']
        );

        $data = array_map(function ($r) {
            return [
                'id' => $r->getId(),
                'mot_cle' => $r->getMotCle(),
                'ville' => $r->getVille(),
                'budget_max' => $r->getBudgetMax(),
                'surface_max' => $r->getSurfaceMax(),
                'nombre_de_chambres' => $r->getNombreDeChambres(),
                'created_at' => $r->getCreatedAt()?->format('Y-m-d H:i'),
            ];
        }, $recherches);

        return $this->json($data);
    }
}
