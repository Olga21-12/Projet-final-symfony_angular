<?php

namespace App\Controller\Api;

use App\Repository\EmplacementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class VilleApiController extends AbstractController
{
    #[Route('/villes', name: 'villes', methods: ['GET'])]
    public function index(EmplacementRepository $emplacementRepository): JsonResponse
    {
        /**
         * 🔹 Étape 1 — Récupération de toutes les villes depuis la base de données
         * On utilise le repository de l'entité Emplacement pour obtenir la liste complète.
         */
        $villes = $emplacementRepository->findAll();

        /**
         * 🔹 Étape 2 — Transformation des objets en tableau simple
         * Comme Angular ne peut pas lire directement des entités PHP,
         * on convertit les objets en un tableau de données JSON.
         */
        $data = array_map(function ($ville) {
            return [
                'id' => $ville->getId(),
                'pays' => $ville->getPays(),
                'ville' => $ville->getVille(),
                'code_postal' => $ville->getCodePostal(),
            ];
        }, $villes);

        /**
         * 🔹 Étape 3 — Envoi de la réponse JSON à Angular
         * La méthode $this->json() convertit automatiquement le tableau en JSON
         * et ajoute les bons en-têtes HTTP pour la réponse.
         */
        return $this->json($data);
    }
}
