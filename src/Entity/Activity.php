<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\Table(name: '`activity`')]
#[ApiResource()]
class Activity {

    public function __construct(?string $name = "name", ?int $maxCapacity = 10, ?\DateTimeInterface $startTime = null, ?\DateTimeInterface $endTime = null)
    {
        $this->name = $name;
        $this->maxCapacity = $maxCapacity;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->bookings = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id")]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le nom de l\'activité est requis.')]
    #[ORM\Column(name:"name", type:"string", length:255, nullable: true)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Le nombre de participants est requis.')]
    #[Assert\Positive(message: 'Le nombre de participants max doit être supérieur à zéro.')]
    #[ORM\Column(name:"max_capacity", type:"integer", nullable: true)]
    private ?int $maxCapacity = null;

    #[Assert\NotBlank(message: 'La date et l\'heure sont requis.')]
    #[Assert\Type(\DateTimeInterface::class, message: 'La date et l\'heure doivent être valides.')]
    #[ORM\Column(name:"start_time", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startTime = null;

    #[Assert\NotBlank(message: 'La date et l\'heure sont requis.')]
    #[Assert\Type(\DateTimeInterface::class, message: 'La date et l\'heure doivent être valides.')]
    #[Assert\GreaterThan(propertyPath: 'startTime', message: 'La date de fin doit être postérieure à la date de début.')]
    #[ORM\Column(name:"end_time", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endTime = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'activity', cascade: ['persist'], orphanRemoval: true)]
    private Collection $bookings;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): static
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setActivity($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getActivity() === $this) {
                $booking->setActivity(null);
            }
        }

        return $this;
    }
}