<?php

namespace App\Controller\Api;

use App\Repository\EmplacementRepository;
use App\Repository\TypesDeBienRepository;
use App\Repository\TypesActiviteRepository;
use App\Repository\ConfortRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/filtre', name: 'api_filtre_')]
class FiltreOptionsController extends AbstractController
{
    #[Route('/options', name: 'options', methods: ['GET'])]
    public function options(
        EmplacementRepository $emplacementRepo,
        TypesDeBienRepository $typeRepo,
        TypesActiviteRepository $activiteRepo,
        ConfortRepository $confortRepo
    ): JsonResponse {
        //  Pays et villes
        $emplacements = $emplacementRepo->findAll();
        $pays = [];
        $villes = [];

        foreach ($emplacements as $e) {
            if ($e->getPays() && !in_array($e->getPays(), $pays)) {
                $pays[] = $e->getPays();
            }
            if ($e->getVille() && !in_array($e->getVille(), $villes)) {
                $villes[] = $e->getVille();
            }
        }

        //  Types de biens
        $types = array_map(fn($t) => $t->getTypeDeBien(), $typeRepo->findAll());

        //  Types d’activités
        $activites = array_map(fn($a) => $a->getTypeActivite(), $activiteRepo->findAll());

        //  Conforts
        $conforts = array_map(fn($c) => $c->getName(), $confortRepo->findAll());

        return $this->json([
            'pays' => $pays,
            'villes' => $villes,
            'types' => $types,
            'activites' => $activites,
            'conforts' => $conforts,
        ]);
    }
}
