<?php

namespace App\Controller\Api;

use App\Entity\Recherche;
use App\Model\SearchData;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/biens', name: 'api_biens_')]
class BienFiltreController extends AbstractController
{
    #[Route('/filtre', name: 'filtre', methods: ['GET'], priority: 10)]
    public function filtre(Request $request, BienRepository $bienRepository, EntityManagerInterface $em): JsonResponse
    {

       $params = $request->query->all(); // renvoie un tableau de tous les paramètres de requête

        $data = new SearchData();
        $data->q          = $params['q'] ?? null;
        $data->pays       = $params['pays'] ?? null;
        $data->ville      = $params['ville'] ?? null;
        $data->type       = $params['typeBien'] ?? null;
        $data->activite   = $params['activite'] ?? null;
        $data->prixMax    = isset($params['prixMax']) && $params['prixMax'] !== '' ? (float)$params['prixMax'] : null;
        $data->surfaceMax = isset($params['surfaceMax']) && $params['surfaceMax'] !== '' ? (float)$params['surfaceMax'] : null;
        $data->chambres   = isset($params['chambres']) && $params['chambres'] !== '' ? (int)$params['chambres'] : null;
       // $data->conforts   = isset($params['conforts']) ? (array)$params['conforts'] : [];

        // Nous obtenons des Biens avec un filtre

        $query = $bienRepository->searchBiensQuery($data);
        $biens = $query->getResult();

        // Nous sauvegardons la recherche pour l'utilisateur
        $user = $this->getUser();
        if ($this->getUser()) {
            $recherche = new Recherche();
            $recherche->setUser($this->getUser());
            $recherche->setMotCle($data->q ?: ($data->activite ?? ''));
            $recherche->setVille($data->ville ?? null);
            $recherche->setBudgetMax($data->prixMax ?? null);
            $recherche->setSurfaceMax($data->surfaceMax ?? null);
            $recherche->setNombreDeChambres($data->chambres ?? null);

            $em->persist($recherche);
            $em->flush();
        }

        return $this->json($biens, 200, [], ['groups' => 'bien:read']);
    }
}
