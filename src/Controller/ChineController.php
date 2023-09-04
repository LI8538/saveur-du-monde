<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChineController extends AbstractController
{
    #[Route('/chine', name: 'app_chine', methods: ['GET'])]
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // return $this->render('product/index.html.twig', [
        //     'products' => $productRepository->findAll(),
        // ]);
        $data = $productRepository->findAll();

        $pagination = $paginator->paginate(
        $data, // Requête contenant les données à paginer
        
        $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
        12 // Nombre de résultats par page
    );
        return $this->render('chine/index.html.twig', [
            'products' => $pagination
        ]);
    }
}
