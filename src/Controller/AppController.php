<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Factory\BookingManagerFactory;
use App\Repository\ActivityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index(ActivityRepository $repoA, BookingManagerFactory $bookingManagerFactory, Request $request): Response
    {        
        $listActivities = $repoA->getAllActivities();

        $booking = new Booking("entrez votre nom", $listActivities[0], new \DateTime("2025-04-08 10:00:00"), 1); 
        $bookingManager = $bookingManagerFactory->create($booking->getActivity()->getName()); 

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $bookingManager->addBooking($booking);
                $this->addFlash('success', 'Réservation enregistrée avec succès.');

                return $this->redirectToRoute('app_booking');

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'listActivities' => $listActivities,
            'form' => $form->createView()
        ]);
    }
}
