<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PaymentController extends AbstractController
{

    // montant lier avec un abonnement avec un prix fixe 
    // #[Route('/payment', name: 'app_payment')]
    // public function index(): Response
    // {
    //     Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

    //     $session = Session::create([
    //         'payment_method_types' => ['card'],
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'eur',
    //                 'unit_amount' => $totalAmount,
    //                 // 'unit_amount' => 1200,

    //                 'product_data' => [
    //                     'name' => 'emporter chez saveur du monde',
    //                     'images' => ['https://raw.githubusercontent.com/Gitubeuse92/SaveursDuMonde/master/public/img/logo.png'],

    //                 ],
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment',
    //         'success_url' => $this->generateUrl('app_payment_success', [], 0),
    //         'cancel_url' => $this->generateUrl('app_payment_cancel', [], 0),
    //     ]);

    //     return $this->redirect($session->url, 303);
    // }





// montant lier avec panier d'achat 
    #[Route('/payment/{totalAmount}', name: 'app_payment')]
    public function index($totalAmount): Response
    {   
        $totalAmounts =  (int)$totalAmount*100; // Remplacez cette valeur par le montant total de votre panier en centimes

        Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $totalAmounts, // Utilisez le montant total passé en paramètre
                    'product_data' => [
                        'name' => 'emporter chez saveur du monde',
                        'images' => ['https://raw.githubusercontent.com/Gitubeuse92/SaveursDuMonde/master/public/img/logo.png'],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_payment_success', [], 0),
            'cancel_url' => $this->generateUrl('app_payment_cancel', [], 0),
        ]);
    
        return $this->redirect($session->url, 303);
    }
    





    #[Route('/payment/success', name: 'app_payment_success')]
    public function success(EntityManagerInterface $em): Response
    {
        // $user = $this->getUser();
        // $user->setRoles(["ROLE_PREMIUM"]);

        // $em->persist($user);
        // $em->flush();

        $this->addFlash('message', 'La paiement a bien été effectué. Vous êtes pouvez venir récupére votre commande !');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/payment/cancel', name: 'app_payment_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('message', 'Le paiement a n\' pas abouti. Réessayez.');

        return $this->redirectToRoute('app_home');
    }
}
