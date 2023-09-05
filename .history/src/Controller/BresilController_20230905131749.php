<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BresilController extends AbstractController
{
    #[Route('/bresil', name: 'app_bresil', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository, ProductRepository $productRepository): Response
    {
        $reviewRepositoryData = $reviewRepository->findAll();
        $entrees = $productRepository->findProductsByCategoryAndType('bresil', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('bresil', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('bresil', 'Dessert');
    
        return $this->render('bresil/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            
        ]);

}}
