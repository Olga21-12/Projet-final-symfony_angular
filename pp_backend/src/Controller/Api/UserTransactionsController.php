<?php

namespace App\Controller\Api;

use App\Entity\Bien;
use App\Repository\ReservationRepository;
use App\Repository\OffresVenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'api_user_')]
class UserTransactionsController extends AbstractController
{
    #[Route('/{id}/transactions', name: 'transactions', methods: ['GET'])]
    public function transactions(
        int $id,
        ReservationRepository $reservationRepo,
        OffresVenteRepository $venteRepo,
        EntityManagerInterface $em
    ): JsonResponse {
        $reservations = $reservationRepo->findBy(['user' => $id]);
        $ventes = $venteRepo->findBy(['user' => $id]);

        $data = [];

        // === LOCATIONS ===
        foreach ($reservations as $r) {
            $bien = $r->getBien();
            if (!$bien) continue;

            $photos = array_map(
                fn($p) => '/uploads/biens/' . $p->getImageName(),
                $bien->getPhotos()->toArray()
            );

            $data[] = [
                'type' => 'location',
                'bien_id' => $bien->getId(),
                'adresse' => $bien->getAdresse(),
                'ville' => $bien->getEmplacement()?->getVille(),
                'pays' => $bien->getEmplacement()?->getPays(),
                'prix' => $bien->getPrix(),
                'date_debut' => $r->getDateDebut()?->format('Y-m-d'),
                'date_fin' => $r->getDateFin()?->format('Y-m-d'),
                'photo' => $photos[0] ?? null,
                'type_bien' => $bien->getType()?->getTypeDeBien(),
            ];
        }

        // === ACHATS ===
        foreach ($ventes as $v) {
            $bien = $v->getBien();
            if (!$bien) continue;

            $photos = array_map(
                fn($p) => '/uploads/biens/' . $p->getImageName(),
                $bien->getPhotos()->toArray()
            );

            $data[] = [
                'type' => 'achat',
                'bien_id' => $bien->getId(),
                'adresse' => $bien->getAdresse(),
                'ville' => $bien->getEmplacement()?->getVille(),
                'pays' => $bien->getEmplacement()?->getPays(),
                'prix' => $bien->getPrix(),
                'date_achat' => method_exists($v, 'getDateAchat') ? $v->getDateAchat()?->format('Y-m-d') : null,
                'photo' => $photos[0] ?? null,
                'type_bien' => $bien->getType()?->getTypeDeBien(),
            ];
        }

        return $this->json($data);
    }
}
