<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/contact', name: 'api_contact_')]
class ContactApiController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
public function contact(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!$data || empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            return new JsonResponse(['error' => 'Tous les champs sont obligatoires.'], 400);
        }

        $contact = new Contact();
        $contact->setNom($data['name']);
        $contact->setEmail($data['email']);
        $contact->setMessage($data['message']);
        $contact->setCreatedAt(new \DateTimeImmutable());
        $contact->setIsRead(false);

        $em->persist($contact);
        $em->flush();

        return new JsonResponse(['message' => 'Message reçu avec succès !'], 201);
    }

}
