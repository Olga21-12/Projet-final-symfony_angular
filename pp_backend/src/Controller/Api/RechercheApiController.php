<?php

namespace App\Controller\Api;

use App\Repository\RechercheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
                'ville' => $r->getVille(),
                'types' => array_map(fn($t) => $t->getTypeDeBien(), $r->getTypesDeBien()->toArray()),
                'activite' => $r->getTypeActivite()?->getNom(),
                'created_at' => $r->getCreatedAt()?->format('Y-m-d H:i'),
            ];
        }, $recherches);

        return $this->json($data);
    }

    #[Route('/save', name: 'save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$data) {
        return $this->json(['error' => 'Aucune donnée reçue'], 400);
    }

    $user = null;
    if (!empty($data['user_id'])) {
        $user = $em->getRepository(\App\Entity\User::class)->find($data['user_id']);
    }

    if (!$user) {
        return $this->json(['error' => 'Utilisateur introuvable'], 400);
    }

        $recherche = new \App\Entity\Recherche();
    if ($user) {
        $recherche->setUser($user);
    }

    $recherche->setPays($data['pays'] ?? null);
    $recherche->setVille($data['ville'] ?? null);
    $recherche->setTypeBien($data['typeBien'] ?? null);

        $em->persist($recherche);
        $em->flush();

        return $this->json(['message' => 'Recherche sauvegardée avec succès ✅']);
    }

    // 🔹 LISTE DES RECHERCHES D'UN UTILISATEUR
    #[Route('/user/{id}', name: 'by_user', methods: ['GET'])]
    public function listByUser(int $id, RechercheRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $user = $em->getRepository(\App\Entity\User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $recherches = $repo->findBy(['user' => $user], ['createdAt' => 'DESC']);

        $data = array_map(function ($r) {
            $pays = $r->getEmplacement()?->getPays();
            $ville = $r->getVille();
            $types = $r->getTypesDeBien();
            $typeBien = count($types) > 0 ? $types->first()->getTypeDeBien() : null;

            return [
                'id' => $r->getId(),
                'pays' => $pays,
                'ville' => $ville,
                'type_bien' => $typeBien,
                'created_at' => $r->getCreatedAt()?->format('Y-m-d H:i'),
            ];
        }, $recherches);

        return $this->json($data);
    }
}
