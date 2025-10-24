<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Bien;
use App\Entity\TypesDeBien;
use App\Entity\Confort;
use App\Entity\Emplacement;
use App\Entity\TypesActivite;
use App\Model\SearchData;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/api/biens', name: 'api_biens_')]

class BienApiController extends AbstractController
{
   // 1. LISTE DE TOUS LES BIENS
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(BienRepository $repo): JsonResponse
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
                'type' => $bien->getType()?->getTypeDeBien(),
                'activite' => $bien->getTypeActivite()?->getNom(),
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
                'created_at' => $bien->getCreatedAt()?->format('Y-m-d'),
                'updated_at' => $bien->getUpdatedAt()?->format('Y-m-d'),
            ];
        }, $biens);

        return $this->json($data);
    }

    // 2. COMPTE DES BIENS
    #[Route('/count', name: 'count', methods: ['GET'])]
        public function count(BienRepository $repo): JsonResponse
        {
            $count = $repo->count([]);
            return $this->json(['total' => $count]);
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
            'type' => [
                'id' => $bien->getType()?->getId(),
                'type_de_bien' => $bien->getType()?->getTypeDeBien(),
            ],
            'activite' => [
                'id' => $bien->getTypeActivite()?->getId(),
                'type_activite' => $bien->getTypeActivite()?->getNom(),
            ],
            'emplacement' => [
            'pays' => $bien->getEmplacement()?->getPays(),
            'ville' => $bien->getEmplacement()?->getVille(),
            ],
            'conforts' => array_map(fn($c) => $c->getName(), $bien->getConfort()->toArray()),
            'photos' => array_map(fn($p) => '/uploads/biens/' . $p->getImageName(), $bien->getPhotos()->toArray()),
            'proprietaire' => [
                'id' => $bien->getUser()?->getId(),
                'nom' => $bien->getUser()?->getNom(),
                'prenom' => $bien->getUser()?->getPrenom(),
                'surnom' => $bien->getUser()?->getSurnom(),
                'email' => $bien->getUser()?->getEmail(),
            ],
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
        if (!empty($data['user_id'])) {
            $user = $em->getRepository(User::class)->find($data['user_id']);
            if ($user) {
                $bien->setUser($user);
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

         //  Vérification : Seul le propriétaire peut supprimer
        $user = $this->getUser();
        if (!$user || $bien->getProprietaire() !== $user) {
            return $this->json(['error' => 'Accès refusé — vous n’êtes pas le propriétaire.'], 403);
        }

    // Supprimé de la base de données (les photos restent dans /uploads/biens)
        $em->remove($bien);
        $em->flush();

        return $this->json(['message' => 'Le logement a été supprimé avec succès ✅']);
    }

#[Route('/{id}', name: 'update', methods: ['PUT','POST', 'POST'])]
public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
{
    /** @var Bien|null $bien */
    $bien = $em->getRepository(Bien::class)->find($id);
    if (!$bien) {
        return $this->json(['error' => 'Bien introuvable'], 404);
    }

    $data  = $request->request->all();
    $files = $request->files->all();

    // --- Champs scalaires ---
    if (isset($data['adresse']))               { $bien->setAdresse((string)$data['adresse']); }
    if (isset($data['description']))           { $bien->setDescription($data['description'] !== '' ? (string)$data['description'] : null); }
    if (isset($data['prix']) && is_numeric($data['prix']))                 { $bien->setPrix((float)$data['prix']); }
    if (isset($data['surface']) && is_numeric($data['surface']))           { $bien->setSurface((float)$data['surface']); }
    if (isset($data['nombre_de_chambres']) && is_numeric($data['nombre_de_chambres'])) {
        $bien->setNombreDeChambres((int)$data['nombre_de_chambres']);
    }
    if (isset($data['disponibilite']))         { $bien->setDisponibilite(filter_var($data['disponibilite'], FILTER_VALIDATE_BOOL)); }
    if (isset($data['luxe']))                  { $bien->setLuxe(filter_var($data['luxe'], FILTER_VALIDATE_BOOL)); }

    // --- Relations: Type de bien ---
    if (array_key_exists('type', $data)) {
        if ($data['type'] === '' || $data['type'] === null) {
            $bien->setType(null);
        } else {
            $type = $em->getRepository(TypesDeBien::class)->find((int)$data['type']);
            if ($type) { $bien->setType($type); }
        }
    }

    // --- Relations: Type d’activité ---
    if (array_key_exists('activite', $data)) {
        if ($data['activite'] === '' || $data['activite'] === null) {
            $bien->setTypeActivite(null);
        } else {
            $act = $em->getRepository(TypesActivite::class)->find((int)$data['activite']);
            if ($act) { $bien->setTypeActivite($act); }
        }
    }

    // --- Relation: Emplacement (ожидаем ID города) ---
    if (array_key_exists('ville', $data)) {
        if ($data['ville'] === '' || $data['ville'] === null) {
            $bien->setEmplacement(null);
        } else {
            $empl = $em->getRepository(Emplacement::class)->find((int)$data['ville']);
            if ($empl) { $bien->setEmplacement($empl); }
        }
    }

    // --- ManyToMany: Conforts (перезапись списка) ---
    if (isset($data['conforts']) && is_array($data['conforts'])) {
        // очистить текущие
        foreach ($bien->getConfort() as $existing) {
            $bien->removeConfort($existing);
        }
        // добавить присланные
        foreach ($data['conforts'] as $confId) {
            $conf = $em->getRepository(Confort::class)->find((int)$confId);
            if ($conf) { $bien->addConfort($conf); }
        }
    }

    // --- Photos: ajout de nouvelles images (max 4) ---
$uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/biens';
if (!is_dir($uploadsDir)) { @mkdir($uploadsDir, 0777, true); }

// ⚠️ ВАЖНО: поле именно 'photos[]' на фронте → здесь читаем 'photos'
$files = $request->files->get('photos');

// Нормализуем в массив
if ($files instanceof UploadedFile || $files === null) {
    $files = $files ? [$files] : [];
} elseif (!is_array($files)) {
    return $this->json(['error' => 'Format de fichiers invalide.'], 400);
}

if (count($files) > 4) {
    return $this->json(['error' => 'Maximum 4 photos autorisées.'], 400);
}

// Разрешённые mime-типы и лимит размера (например, 8 МБ на файл)
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
$maxPerFileBytes = 8 * 1024 * 1024;

foreach ($files as $idx => $file) {
    if (!$file) { continue; }

    // Если PHP вернул ошибку — покажем оригинальное сообщение
    if (!$file->isValid()) {
        return $this->json(['error' => 'Upload invalide: '.$file->getErrorMessage()], 400);
    }

    // Тип
    $mime = $file->getMimeType();
    if (!in_array($mime, $allowedMime, true)) {
        return $this->json(['error' => 'Type de fichier non supporté (autorisé: JPG, PNG, WEBP).'], 400);
    }

    // Размер
    if ($file->getSize() > $maxPerFileBytes) {
        return $this->json(['error' => 'Fichier trop volumineux (max 8 Mo par image).'], 400);
    }

    // Сохранение
    $ext = $file->guessExtension() ?: 'jpg';
    $newFilename = uniqid('bien_').'.'.$ext;

    try {
        $file->move($uploadsDir, $newFilename);

        $photo = new \App\Entity\Photo();
        $photo->setImageName($newFilename);
        $photo->setBien($bien);
        $em->persist($photo);

    } catch (\Throwable $e) {
    return $this->json([
        'error' => 'Erreur interne : ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], 500);
    }
}

    $em->flush();

    return $this->json(['message' => 'Bien mis à jour avec succès ✅', 'id' => $bien->getId()]);
    }

    #[Route('/api/biens/user/{id}', name: 'biens_by_user', methods: ['GET'])]
        public function getBiensByUser(EntityManagerInterface $em, int $id): JsonResponse
        {
            $biens = $em->getRepository(Bien::class)->findBy(['user' => $id]);
            return $this->json($biens, 200, [], ['groups' => 'bien:read']);
        }


}
