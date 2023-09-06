<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscriptionController extends AbstractController
{
    #[Route('/la-carte', name: 'app_subscription', methods: ['GET', 'POST'])]
    public function index(
        ProductRepository $productRepository,
    ): Response
    {
        $productRepositoryData = $productRepository->findAll();

        $entrees = $productRepository->findProductsType($category, 'Entrée');
        $plats = $productRepository->findProductsType($category, 'Entrée');
        $desserts = $productRepository->findProductsType($category, 'Entrée');
        
            $entrees[] = $productRepository->findProductsByCategoryAndType($category, 'Entrée');
            $plats[] = $productRepository->findProductsByCategoryAndType($category, 'Plat');
            $desserts[] = $productRepository->findProductsByCategoryAndType($category, 'Dessert');
        }

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'products' => $productRepositoryData,
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
        ]);
    }
}
