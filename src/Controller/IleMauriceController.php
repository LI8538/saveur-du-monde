<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IleMauriceController extends AbstractController
{
    #[Route('/ile/maurice', name: 'app_ile_maurice')]
    public function index(): Response
    {
        return $this->render('ile_maurice/index.html.twig', [
            'controller_name' => 'IleMauriceController',
        ]);
    }
}
