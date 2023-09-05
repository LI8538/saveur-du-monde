<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CamerounController extends AbstractController
{
    #[Route('/cameroun', name: 'app_cameroun', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $entrees = $productRepository->findProductsByCategoryAndType('cameroun', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('cameroun', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('cameroun', 'Dessert');
    
        return $this->render('cameroun/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
        ]);

}}
