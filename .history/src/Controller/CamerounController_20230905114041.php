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

class camerounController extends AbstractController
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
