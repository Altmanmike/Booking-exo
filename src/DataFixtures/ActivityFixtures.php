<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $activities = [
            ['name' => 'Surf', 'maxCapacity' => 10, 'start' => '09:00', 'end' => '18:00'],
            ['name' => 'Parapente', 'maxCapacity' => 5, 'start' => '10:00', 'end' => '16:00'],
            ['name' => 'Escalade', 'maxCapacity' => 8, 'start' => '08:00', 'end' => '17:00'],
        ];

        foreach ($activities as $index => $data) {
            $activity = new Activity();
            $activity->setName($data['name']);
            $activity->setMaxCapacity($data['maxCapacity']);
            $activity->setStartTime(new \DateTime($data['start']));
            $activity->setEndTime(new \DateTime($data['end']));
        
            $manager->persist($activity);
        
            // référence nommée pour BookingFixtures
            $this->addReference('activity_' . $index, $activity);
        }
    }
}