<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Emplacement;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/api', name: 'api_')]
class RegistrationApiController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier,
                                private MailerInterface $mailer)
    {
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): JsonResponse {

        /**
         *  Étape 1 — Récupération des données du formulaire
         * Ici on utilise $request->request->all() au lieu de json_decode(),
         * car Angular envoie les données sous format FormData (multipart/form-data),
         * et non pas en JSON.
         */
        $data = $request->request->all();

        //  Récupération du fichier photo, s’il existe
        $file = $request->files->get('photo');

        /**
         *  Étape 2 — Vérification des champs obligatoires
         * Si certains champs essentiels sont absents (email ou mot de passe),
         * on renvoie une erreur 400 (mauvaise requête).
         */
        if (!isset($data['email'], $data['password'], $data['agreeTerms'])) {
            return $this->json(['error' => 'Les champs requis sont manquants.'], 400);
        }

        // Vérifie que l'utilisateur a accepté les conditions
        if ($data['agreeTerms'] != '1') {
            return $this->json(['error' => 'Les conditions générales doivent être acceptées.'], 400);
        }

        /**
         *  Étape 3 — Vérification si un utilisateur avec le même email existe déjà
         */
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json(['error' => 'Un compte avec cet email existe déjà.'], 400);
        }

        /**
         *  Étape 4 — Création de l’objet User et remplissage des données
         */

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles([$data['role'] ?? 'ROLE_CLIENT']);
        $user->setPassword($hasher->hashPassword($user, $data['password']));
        $user->setNom($data['nom'] ?? '');
        $user->setPrenom($data['prenom'] ?? '');
        $user->setSurnom($data['surnom'] ?? '');
        $user->setAdresse($data['adresse'] ?? '');
        $user->setTelephone($data['telephone'] ?? '');
        $user->setDateDeNaissance(
            !empty($data['date_de_naissance'])
                ? new \DateTime($data['date_de_naissance'])
                : null
        );

        //  Étape 5 — Association avec la ville et pays
        if (!empty($data['ville'])) {
            $emplacement = $em->getRepository(Emplacement::class)->find($data['ville']);
            if ($emplacement) {
                $user->setEmplacement($emplacement);
            }
        }

        /**
         *  Étape 6 — Gestion du fichier photo
         * Si une photo a été téléchargée, on la déplace dans le dossier public/uploads/profiles.
         * Sinon, on attribue l’image par défaut "sans_photo.png".
         */
        if ($file) {
            $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/profiles';
            $newFilename = uniqid() . '.' . $file->guessExtension();

            try {
                $file->move($uploadsDir, $newFilename);
                $user->setImageName($newFilename);
            } catch (FileException $e) {
                return $this->json(['error' => 'Erreur lors du téléchargement de la photo.'], 500);
            }
        } else {
            $user->setImageName('sans_photo.png');
        }

        /**
         *  Étape 7 — Enregistrement de l’utilisateur dans la base de données
         */
        $em->persist($user);
        $em->flush();

        /**
         *  Étape 8 — Envoi d’un email de confirmation
         * On génère le lien de vérification, mais on le redirige vers le FRONT (Angular).
         */
        $signedUrl = $this->emailVerifier->generateSignedUrl('app_verify_email', $user);
            $frontendUrl = 'http://localhost:4200/verify-email?token=' . urlencode($signedUrl);

            $email = (new TemplatedEmail())
                ->from(new Address('admin@purrpalace.com', 'PurrPalace'))
                ->to($user->getEmail())
                ->subject('✨ Confirmez votre adresse email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context([
                    'verifyUrl' => $frontendUrl,
                    'user' => $user,
                ]);

            $this->mailer->send($email);

        /**
         * Étape 9 — Réponse finale envoyée à Angular
         * Si tout s’est bien passé, on renvoie un code HTTP 201 (créé)
         * et un message de succès en JSON.
         */
        return $this->json([
            'status' => 'success',
            'message' => 'Inscription réussie ! Veuillez vérifier votre email pour confirmer votre compte.'
        ], 201);
    }

    #[Route('/verify-email', name: 'api_verify_email', methods: ['GET'])]
        public function verifyUserEmail(Request $request, EntityManagerInterface $em): JsonResponse
        {
    $tokenUrl = $request->query->get('token');

    if (!$tokenUrl) {
        return $this->json(['error' => 'Lien de vérification invalide.'], 400);
    }

    /**
 * SymfonyCasts VerifyEmailBundle — extrait le vrai token depuis l’URL signée.
 * Le token généré par EmailVerifier est une URL complète encodée dans notre paramètre.
 */
$decodedUrl = urldecode($tokenUrl);

// 🔹 Извлекаем ID пользователя из токена (из параметра id=)
parse_str(parse_url($decodedUrl, PHP_URL_QUERY), $queryParams);
$userId = $queryParams['id'] ?? null;

if (!$userId) {
    return $this->json(['error' => 'Utilisateur non trouvé dans le lien.'], 400);
}

$user = $em->getRepository(User::class)->find($userId);
if (!$user) {
    return $this->json(['error' => 'Utilisateur introuvable.'], 404);
}

try {
    // ✅ Передаём реального пользователя, найденного по ID
    $this->emailVerifier->handleEmailConfirmation(
        $request->duplicate([], null, ['REQUEST_URI' => $decodedUrl]),
        $user
    );
} catch (\Exception $e) {
    return $this->json(['error' => 'Le lien de vérification est invalide ou expiré.'], 400);
}


    // Si tout s’est bien passé
    return $this->json([
        'status' => 'success',
        'message' => 'Votre adresse e-mail a été vérifiée avec succès ! 🎉'
    ]);
}

}
