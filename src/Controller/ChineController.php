<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChineController extends AbstractController
{
    #[Route('/chine', name: 'app_chine', methods: ['GET'])]
    public function index(ProductRepository $productRepository, CartService $cartService): Response
    {
        $entrees = $productRepository->findProductsByCategoryAndType('Chine', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('Chine', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('Chine', 'Dessert');

        return $this->render('chine/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'cart' => $cartService->getTotal()
        ]);
    }
}
