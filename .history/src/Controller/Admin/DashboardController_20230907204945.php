<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Publication;
use App\Entity\Purchase;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SaveursDuMonde');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Réservation', 'fas fa-calendar-days', Reservation::class);
        yield MenuItem::linkToCrud('Publications', 'fas fa-envelope', Publication::class);
        yield MenuItem::linkToCrud('Reviews', 'fas fa-star', Review::class);
        yield MenuItem::section('Gestion de Produit');
        yield MenuItem::linkToCrud('Produit', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Menu', 'fas fa-fish', Menu::class);
        yield MenuItem::linkToCrud('Catégory', 'fas fa-folder-open', Category::class);
        // yield MenuItem::linkToCrud('Achat', 'fas fa-cart-shopping', Purchase::class);
        yield MenuItem::section('Autres');
    }
}

