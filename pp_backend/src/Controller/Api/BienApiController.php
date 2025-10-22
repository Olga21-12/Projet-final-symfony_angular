<?php

namespace App\Controller\Api;

use App\Entity\Bien;
use App\Entity\TypesDeBien;
use App\Entity\Confort;
use App\Entity\Emplacement;
use App\Entity\TypesActivite;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/api/biens', name: 'api_biens_')]

class BienApiController extends AbstractController
{
    // 1. LISTE DE TOUS LES BIENS
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $em,
                          BienRepository $repo): JsonResponse
    {

        $biens = $repo->findAll();

        $data = array_map(function (Bien $bien) {
            return [
                'id' => $bien->getId(),
                'adresse' => $bien->getAdresse(),
                'description' => $bien->getDescription(),
                'prix' => $bien->getPrix(),
                'surface' => $bien->getSurface(),
                'nombre_de_chambres' => $bien->getNombreDeChambres(),
                'disponibilite' => $bien->isDisponibilite(),
                'luxe' => $bien->isLuxe(),
                'created_at' => $bien->getCreatedAt()?->format('Y-m-d'),
                'updated_at' => $bien->getUpdatedAt()?->format('Y-m-d'),
                'type' => $bien->getType()?->getTypeDeBien(),
                'activite' => $bien->getTypeActivite()?->getTypeActivite(),
                'proprietaire' => $bien->getUser()?->getSurnom() ?? 'Anonyme',
                'created_ago' => $bien->getCreatedAt()?->diff(new \DateTime())->days,
                'emplacement' => [
                    'pays' => $bien->getEmplacement()?->getPays(),
                    'ville' => $bien->getEmplacement()?->getVille(),
                ],
                'conforts' => array_map(
                    fn(Confort $c) => $c->getName(),
                    $bien->getConfort()->toArray()
                ),
                'photos' => array_map(
                    fn($photo) => '/uploads/biens/' . $photo->getImageName(),
                    $bien->getPhotos()->toArray()
                ),
            ];
        }, $biens);

        return $this->json($data);
    }

    //  AFFICHAGE D’UN SEUL BIEN
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(EntityManagerInterface $em, int $id): JsonResponse
    {
        $bien = $em->getRepository(Bien::class)->find($id);

        if (!$bien) {
            return $this->json(['error' => 'Bien introuvable'], 404);
        }

        $data = [
            'id' => $bien->getId(),
            'adresse' => $bien->getAdresse(),
            'description' => $bien->getDescription(),
            'prix' => $bien->getPrix(),
            'surface' => $bien->getSurface(),
            'nombre_de_chambres' => $bien->getNombreDeChambres(),
            'disponibilite' => $bien->isDisponibilite(),
            'luxe' => $bien->isLuxe(),
            'created_at' => $bien->getCreatedAt()?->format('Y-m-d'),
            'updated_at' => $bien->getUpdatedAt()?->format('Y-m-d'),
            'type' => $bien->getType()?->getName(),
            'activite' => $bien->getActivite()?->getName(),
            'emplacement' => $bien->getEmplacement()?->getVille() . ', ' . $bien->getEmplacement()?->getPays(),
            'conforts' => array_map(fn(Confort $c) => $c->getName(), $bien->getConforts()->toArray()),
            'photos' => array_map(fn($p) => '/uploads/biens/' . $p->getImageName(), $bien->getPhotos()->toArray()),
        ];

        return $this->json($data);
    }

    // 3. CRÉATION D’UN NOUVEAU BIEN
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->request->all();
        $files = $request->files->all();

        // Vérifications basiques
        if (empty($data['adresse']) || empty($data['prix']) || empty($data['surface'])) {
            return $this->json(['error' => 'Champs obligatoires manquants.'], 400);
        }

        $bien = new Bien();
        $bien->setAdresse($data['adresse']);
        $bien->setDescription($data['description'] ?? null);
        $bien->setPrix((float)$data['prix']);
        $bien->setSurface((float)$data['surface']);
        $bien->setNombreDeChambres((int)($data['nombre_de_chambres'] ?? 1));
        $bien->setDisponibilite((bool)($data['disponibilite'] ?? true));
        $bien->setLuxe((bool)($data['luxe'] ?? false));
        $bien->setCreatedAt(new \DateTimeImmutable());
        $bien->setUpdatedAt(new \DateTimeImmutable());

        // 🔹 Type
        if (!empty($data['type'])) {
            $type = $em->getRepository(TypesDeBien::class)->find($data['type']);
            if ($type) $bien->setType($type);
        }

        // 🔹 Activité
        if (!empty($data['activite'])) {
            $activite = $em->getRepository(TypesActivite::class)->find($data['activite']);
            if ($activite) $bien->setTypeActivite($activite);
        }

        // 🔹 Emplacement (ville / pays)
        if (!empty($data['ville'])) {
            $emplacement = $em->getRepository(Emplacement::class)->find($data['ville']);
            if ($emplacement) $bien->setEmplacement($emplacement);
        }

        // 🔹 Conforts (plusieurs cases cochées)
        if (!empty($data['conforts']) && is_array($data['conforts'])) {
            foreach ($data['conforts'] as $idConfort) {
                $conf = $em->getRepository(Confort::class)->find($idConfort);
                if ($conf) $bien->addConfort($conf);
            }
        }

        // Photos
        $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/biens';
        if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);

        if (!empty($files['photos']) && is_array($files['photos'])) {
            foreach ($files['photos'] as $file) {
                if ($file) {
                    $newFilename = uniqid() . '.' . $file->guessExtension();
                    try {
                        $file->move($uploadsDir, $newFilename);
                        $photo = new \App\Entity\Photo();
                        $photo->setImageName($newFilename);
                        $photo->setBien($bien);
                        $em->persist($photo);
                    } catch (FileException $e) {
                        return $this->json(['error' => 'Erreur lors du téléchargement d’une photo.'], 500);
                    }
                }
            }
        }

        $em->persist($bien);
        $em->flush();

        return $this->json(['message' => 'Bien ajouté avec succès ✅', 'id' => $bien->getId()]);
    }

    // 4. SUPPRESSION D’UN BIEN
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, int $id): JsonResponse
    {
        $bien = $em->getRepository(Bien::class)->find($id);

        if (!$bien) {
            return $this->json(['error' => 'Bien introuvable'], 404);
        }

        $em->remove($bien);
        $em->flush();

        return $this->json(['message' => 'Bien supprimé avec succès 🗑️']);
    }
}
