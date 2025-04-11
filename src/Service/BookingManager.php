<?php

namespace App\Service;

use Exception;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingManager {

    private array $bookings = [];

    function __construct(
        private BookingRepository $repoB, 
        private ActivityRepository $repoA, 
        private string $activityName, 
        private EntityManagerInterface $entityManager
        ) {}

    public function addBooking(Booking $booking): void {

        // Vérifier la disponibilité          
        if ($this->repoA->getActivityByName($this->activityName)->getStartTime()->format('H') > $booking->getBookingTime()->format('H')) {
            throw new Exception("❌ Cet horaire " .$booking->getBookingTime()->format('H'). " heure est trop tôt pour réserver l'activité ".$this->activityName);
        }

        if ($this->repoA->getActivityByName($this->activityName)->getEndTime()->format('H') <= $booking->getBookingTime()->format('H')) {
            throw new Exception("❌ Cet horaire " .$booking->getBookingTime()->format('H'). " heure est trop tard pour réserver l'activité ".$this->activityName);
        }

        // Vérifier la capacité
        $nb_participants=0;
        $bookings = $this->repoB->getAllBookings();           
        foreach ($bookings as $b) {                  
            if (($this->activityName === $b->getActivity()->getName()) && ($b->getBookingTime() == $booking->getBookingTime())) {                                              
                $nb_participants += $b->getParticipants();                             
            }          
        }           
        if ($this->repoA->getActivityByName($this->activityName)->getMaxCapacity() < ($booking->getParticipants() + $nb_participants)) {
            throw new Exception("❌ Le nombre de participant ".$booking->getParticipants()." est trop élevé, maximum autorisé ".$this->repoA->getActivityByName($this->activityName)->getMaxCapacity().", déjà inscris à la même heure : ".$nb_participants);
        }

        // Vérifier les doublons
        if ($this->repoB->getBookingByUserNameAndActivity($booking->getUserName(), $this->activityName)) {
            throw new Exception("❌ Cette personne ".$booking->getUserName()." a déjà émit une réservation pour l'activité ".$this->activityName);
        }

        // Ajouter la réservation
        $this->repoB->add($booking);
        $this->entityManager->flush();
    }

    public function listBookings(): array {        
        $bookings = $this->repoB->getAllBookings();
        return $bookings;
    }
}