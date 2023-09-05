<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// class CamerounController extends AbstractController
// {
//     #[Route('/cameroun', name: 'app_cameroun')]
//     public function index(): Response
//     {
//         return $this->render('cameroun/index.html.twig', [
//             'controller_name' => 'CamerounController',
//         ]);
//     }
// }

class BresilController extends AbstractController
{
    #[Route('/bresil', name: 'app_bresil', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $entrees = $productRepository->findProductsByCategoryAndType('bresil', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('bresil', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('bresil', 'Dessert');
    
        return $this->render('bresil/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
        ]);

}}
