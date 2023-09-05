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