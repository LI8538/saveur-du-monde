<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class IleMauriceController extends AbstractController
// {
//     #[Route('/ile/maurice', name: 'app_ile_maurice')]
//     public function index(): Response
//     {
//         return $this->render('ile_maurice/index.html.twig', [
//             'controller_name' => 'IleMauriceController',
//         ]);
//     }
// }

class IleMauriceController extends AbstractController
{
    #[Route('/ile/maurice', name: 'app_ile_maurice', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $entrees = $productRepository->findProductsByCategoryAndType('île Maurice', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('maurice', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('maurice', 'Dessert');
    
        return $this->render('maurice/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
        ]);

}}