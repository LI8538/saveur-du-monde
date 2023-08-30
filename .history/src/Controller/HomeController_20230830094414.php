<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $reviewRepository, Request $request,): Response
    {
        $data = $reviewRepository->findAll();

        // $pagination = $paginator->paginate(
        // $data, // Requête contenant les données à paginer

        $request->query->getInt('page', 1); // Numéro de la page en cours, 1 par défaut
        4;// Nombre de résultats par page
    );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'reviews' => $data
        ]);
    }
}