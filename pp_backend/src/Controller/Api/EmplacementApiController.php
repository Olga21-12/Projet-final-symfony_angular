<?php

namespace App\Controller\Api;

use App\Entity\Emplacement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_emplacement_')]
class EmplacementApiController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    /**
     * 🔹 Étape 1 — Récupérer la liste des pays (sans doublons)
     */
    #[Route('/pays', name: 'pays', methods: ['GET'])]
    public function getPays(): JsonResponse
    {
        $paysList = $this->em->getRepository(Emplacement::class)
            ->createQueryBuilder('e')
            ->select('DISTINCT e.pays')
            ->orderBy('e.pays', 'ASC')
            ->getQuery()
            ->getResult();

        $data = array_map(fn($row) => $row['pays'], $paysList);

        return $this->json($data);
    }

    /**
     * 🔹 Étape 2 — Récupérer les villes selon un pays choisi
     */
    #[Route('/villes', name: 'villes', methods: ['GET'])]
    public function getVilles(Request $request): JsonResponse
    {
        $pays = $request->query->get('pays');

        $repo = $this->em->getRepository(Emplacement::class);
        $qb = $repo->createQueryBuilder('e');

        if ($pays) {
            $qb->where('e.pays = :pays')->setParameter('pays', $pays);
        }

        $villes = $qb->orderBy('e.ville', 'ASC')->getQuery()->getResult();

        $data = array_map(function (Emplacement $ville) {
            return [
                'id' => $ville->getId(),
                'ville' => $ville->getVille(),
                'code_postal' => $ville->getCodePostal(),
            ];
        }, $villes);

        return $this->json($data);
    }
}
