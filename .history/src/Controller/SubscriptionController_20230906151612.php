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
        Request $request,
    ): Response
    {
        $productRepositoryData = $productRepository->findAll();
        
        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'products' => $productRepositoryData,
        ]);
    }
}
