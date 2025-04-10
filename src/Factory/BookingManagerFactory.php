<?php

namespace App\Factory;

use App\Repository\ActivityRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\BookingManager;

class BookingManagerFactory
{
    public function __construct(
        private BookingRepository $repoB,
        private ActivityRepository $repoA,
        private EntityManagerInterface $entityManager
    ) {}

    public function create(string $activityName): BookingManager
    {
        return new BookingManager($this->repoB, $this->repoA, $activityName, $this->entityManager);
    }
}
