<?php

namespace App\Controller;

use App\Factory\BookingManagerFactory;
use App\Service\BookingManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BookingController extends AbstractController
{
    private BookingManagerFactory $bookingManagerFactory;

    function __construct(BookingManagerFactory $bookingManagerFactory) {
        $this->bookingManagerFactory = $bookingManagerFactory;
    }

    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        $bookingManager = $this->bookingManagerFactory->create('Surf'); // ou autre activité dynamique
        $listBookings = $bookingManager->listBookings();

        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
            'listBookings' => $listBookings
        ]);
    }
}
