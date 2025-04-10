<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Entity\Activity;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\Table(name: '`booking`')]
#[ApiResource()]
class Booking {

    public function __construct(?string $userName = "name", ?Activity $activity = null, ?\DateTimeInterface $bookingTime = null, ?int $participants = 1) 
    {
        $this->userName = $userName;
        $this->activity = $activity;
        $this->bookingTime = $bookingTime;
        $this->participants = $participants;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id")]
    private ?int $id = null;
    
    #[Assert\NotBlank(message: 'Votre nom est requis.')]
    #[ORM\Column(name: "user_name", length: 255, nullable: true)]
    private ?string $userName = null;

    #[Assert\NotNull(message: 'L\'activité est requise.')]
    #[ORM\ManyToOne(targetEntity: Activity::class, inversedBy: 'bookings', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activity $activity = null;

    #[Assert\NotBlank(message: 'La date et l\'heure sont requis.')]
    #[Assert\Type(\DateTimeInterface::class, message: 'La date et l\'heure doivent être valides.')]
    #[ORM\Column(name:"booking_time", type: Types::DATETIME_MUTABLE, nullable: true)]    
    private ?\DateTimeInterface $bookingTime = null;

    #[Assert\NotBlank(message: 'Le nombre de participants est requis.')]
    #[Assert\Positive(message: 'Le nombre de participants doit être supérieur à zéro.')]
    #[ORM\Column(name: "participants", nullable: true)]
    private ?int $participants = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getBookingTime(): ?\DateTimeInterface
    {
        return $this->bookingTime;
    }

    public function setBookingTime(\DateTimeInterface $bookingTime): static
    {
        $this->bookingTime = $bookingTime;

        return $this;
    }

    public function getParticipants(): ?int
    {
        return $this->participants;
    }

    public function setParticipants(int $participants): static
    {
        $this->participants = $participants;

        return $this;
    }
}