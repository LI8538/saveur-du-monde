<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChineController extends AbstractController
{
    #[Route('/chine', name: 'app_chine')]
    public function index(): Response
    {
        return $this->render('chine/index.html.twig', [
            'controller_name' => 'ChineController',
        ]);
    }
}
