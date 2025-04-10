<?php

// src/DataFixtures/BookingFixtures.php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Activity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $bookings = [
            ['userName' => 'Alice',   'activityRef' => 'activity_0', 'time' => '10:00', 'participants' => 2],
            ['userName' => 'Bob',     'activityRef' => 'activity_1', 'time' => '11:00', 'participants' => 1],
            ['userName' => 'Charlie', 'activityRef' => 'activity_2', 'time' => '09:30', 'participants' => 3],
        ];

        foreach ($bookings as $data) {
            $booking = new Booking();
            $booking->setUserName($data['userName']);
            $booking->setActivity($this->getReference($data['activityRef'], Activity::class));
            $booking->setBookingTime(new \DateTime($data['time']));
            $booking->setParticipants($data['participants']);

            $manager->persist($booking);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ActivityFixtures::class,
        ];
    }
}