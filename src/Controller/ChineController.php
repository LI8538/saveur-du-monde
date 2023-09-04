<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChineController extends AbstractController
{
    #[Route('/chine', name: 'app_chine', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $entrees = $productRepository->findProductsByCategoryAndType('Chine', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('Chine', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('Chine', 'Dessert');
    
        return $this->render('chine/index.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
        ]);

}}
