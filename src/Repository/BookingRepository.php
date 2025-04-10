<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 *  
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function add(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Booking[] Returns an array of Booking objects
     */
    public function getAllBookings(): array
    {
        return $this->createQueryBuilder('booking')
            ->orderBy('booking.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Booking|null Return a Booking object
     */
    public function getBookingByUserName(string $username): ?Booking
    {
        return $this->createQueryBuilder('booking')
            ->where('booking.userName = :userName')
            ->setParameter('userName', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Booking|null Return a Booking object
     */
    public function getBookingByTime(string $bookingtime): ?Booking
    {
        return $this->createQueryBuilder('booking')
            ->where('booking.bookingTime = :bookingTime')
            ->setParameter('bookingTime', $bookingtime)
            ->getQuery()            
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Booking|null Return a Booking object
     */
    public function getBookingByUserNameAndActivity(string $username, string $activityName): ?Booking
    {
        return $this->createQueryBuilder('booking')
            ->where('booking.userName = :userName')
            ->setParameter('userName', $username)
            ->andWhere('booking.activity = :activity')            
            ->setParameter('activity', $activityName)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}