<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Bien;
use App\Entity\TypesActivite;
use App\Entity\TypesDeBien;
use App\Entity\Confort;
use App\Entity\Emplacement;
use App\Entity\OffresVente;
use App\Entity\Recherche;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminDashboardController extends AbstractDashboardController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // реальные данные
        $userCount = $this->em->getRepository(User::class)->count([]);
        $bienCount = $this->em->getRepository(Bien::class)->count([]);
        $reservationCount = $this->em->getRepository(Reservation::class)->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'userCount' => $userCount,
            'bienCount' => $bienCount,
            'reservationCount' => $reservationCount,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PurrPalace Administration')
            ->renderContentMaximized(); // панель на всю ширину
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Comptes utilisateurs', 'fa fa-user', User::class);

        yield MenuItem::section('Biens & Types');
        yield MenuItem::linkToCrud('Biens', 'fa fa-building', Bien::class);
        yield MenuItem::linkToCrud('Types d’activité', 'fa fa-briefcase', TypesActivite::class);
        yield MenuItem::linkToCrud('Types de bien', 'fa fa-house', TypesDeBien::class);
        yield MenuItem::linkToCrud('Conforts', 'fa fa-couch', Confort::class);

        yield MenuItem::section('Localisation');
        yield MenuItem::linkToCrud('Emplacements', 'fa fa-map-marker', Emplacement::class);

        yield MenuItem::section('Offres et Réservations');
        yield MenuItem::linkToCrud('Offres de vente', 'fa fa-tag', OffresVente::class);
        yield MenuItem::linkToCrud('Recherches', 'fa fa-search', Recherche::class);
        yield MenuItem::linkToCrud('Réservations', 'fa fa-calendar', Reservation::class);

        yield MenuItem::section('Retour');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home'); // заменишь на свой маршрут Angular/домашней страницы
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out');
    }
}
