<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use App\Repository\ReviewRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(
        ReviewRepository $reviewRepository,
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        Request $request,
        MailerInterface $mailer
    ): Response {
        $reviewRepositoryData = $reviewRepository->findBy([], ['datePublication' => 'DESC']);

        $reviewRepositoryPagination = $paginator->paginate(
            $reviewRepositoryData, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            3 // Nombre de résultats par page
        );

        $productRepositoryData = $productRepository->findAll();

        $productRepositoryPagination = $paginator->paginate(
            $productRepositoryData, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            12 // Nombre de résultats par page
        );
// variables des produits
        $entrees = $productRepository->findProductsByCategoryAndType('Chine', 'Entrée');
        $plats = $productRepository->findProductsByCategoryAndType('Chine', 'Plat');
        $desserts = $productRepository->findProductsByCategoryAndType('Chine', 'Dessert');


        //test contact
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On stocke les données du formulaire dans des variables
            $nom =  $form->get('Nom')->getData();
            $prenom =  $form->get('Prenom')->getData();
            $sujet =  $form->get('Sujet')->getData();
            $email =  $form->get('Email')->getData();
            $tel = $form->get('Telephone')->getData();
            $message =  $form->get('Message')->getData();

            // On envoie l'email avec les données du formulaire
            $contactMessage = (new Email())
                ->from($email)
                ->to('hello@restaurant.fr')
                ->subject('Vous avez reçu un nouveau message de ' . $nom . ' ' . $prenom)
                ->html("
                    <p>Vous avez reçu un nouveau message de la part de ' . $nom . ' ' . $prenom . 'au sujet de ' . $sujet.</p>
                    <p>Le message :</p>
                    <p>' . $message . '</p>
                    <p>Voici ses coordonnées :</p>
                    <ul>
                        <li>Email : ' . $email . '</li>
                        <li>Téléphone : ' . $tel . '</li>
                    </ul>
                ");

            $mailer->send($contactMessage);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_home');
        }
        //test contact  
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'reviews' => $reviewRepositoryPagination,
            'products' => $productRepositoryPagination,
            //injecte et la vue de formulaire dans la vue
            'contactForm' => $form->createView(), // Passer le formulaire à la vue
        ]);
    }
}
