<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }





    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionInterface $session, MailerInterface $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // Persistez l'entité dans la base de données
             $reservation->setIsConfirm(false); // Mettez à jour le statut de confirmation
            $entityManager->persist($reservation);
            $entityManager->flush();

             // Ajouter un flash message pour indiquer le succès de la réservation
            $session->getFlashBag()->add('success', 'Votre réservation a été effectuée avec succès.');


        // Envoyer l'e-mail de validation de réservation
    $emailValidation = (new Email())
    ->from('hello@saveursDuMonde.com')
    ->to('you@example.com') // L'adresse e-mail de l'utilisateur
    ->subject('Confirmation de votre réservation')
    ->text('Votre réservation a été reçue et est en attente de confirmation.')
    ->html('<p>Votre réservation a été confirmée avec succès. Nous avons hâte de vous accueillir chez nous !</p>');
            $mailer->send($emailValidation);

            return $this->redirectToRoute('app_reservation_new', [], Response::HTTP_SEE_OTHER);
        }
                // Envoyer un autre e-mail si le statut de confirmation est mis à true
                if ($reservation->isIsConfirm()){
                    $entityManager->persist($reservation);
            $entityManager->flush();
                    $emailConfirmation = (new Email())
                        ->from('hello@saveursDuMonde.com')
                        ->to('you@example.com') // L'adresse e-mail de l'utilisateur
                        ->subject('Réservation confirmée')
                        ->text('Votre réservation a été confirmée avec succès.')
                        ->html('<p>Votre réservation a été confirmée avec succès. Nous avons hâte de vous accueillir chez nous !</p>');
                
                    $mailer->send($emailConfirmation);
                
                }
        
        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }







    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }






    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
