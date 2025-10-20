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

#[Route('/api', name: 'api_')]
class RegistrationApiController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): JsonResponse {

        /**
         * 🔹 Étape 1 — Récupération des données du formulaire
         * Ici on utilise $request->request->all() au lieu de json_decode(),
         * car Angular envoie les données sous format FormData (multipart/form-data),
         * et non pas en JSON.
         */
        $data = $request->request->all();

        // 🔹 Récupération du fichier photo, s’il existe
        $file = $request->files->get('photo');

        /**
         * 🔹 Étape 2 — Vérification des champs obligatoires
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
         * 🔹 Étape 3 — Vérification si un utilisateur avec le même email existe déjà
         */
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json(['error' => 'Un compte avec cet email existe déjà.'], 400);
        }

        /**
         * 🔹 Étape 4 — Création de l’objet User et remplissage des données
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

        // 🔹 Étape 5 — Association avec la ville et pays
        if (!empty($data['ville'])) {
            $emplacement = $em->getRepository(Emplacement::class)->find($data['ville']);
            if ($emplacement) {
                $user->setEmplacement($emplacement);
            }
        }

        /**
         * 🔹 Étape 6 — Gestion du fichier photo
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
         * 🔹 Étape 7 — Enregistrement de l’utilisateur dans la base de données
         */
        $em->persist($user);
        $em->flush();

        /**
         * 🔹 Étape 8 — Envoi d’un email de confirmation
         * Grâce au bundle symfonycasts/verify-email-bundle,
         * on génère un lien de vérification et on l’envoie à l’utilisateur.
         */
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('admin@purrpalace.com', 'PurrPalace'))
                ->to($user->getEmail())
                ->subject('✨ Confirmez votre adresse email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        /**
         * 🔹 Étape 9 — Réponse finale envoyée à Angular
         * Si tout s’est bien passé, on renvoie un code HTTP 201 (créé)
         * et un message de succès en JSON.
         */
        return $this->json([
            'status' => 'success',
            'message' => 'Inscription réussie ! Veuillez vérifier votre email pour confirmer votre compte.'
        ], 201);
    }
}
