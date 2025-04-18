# Booking-exo ✅

## **Gestion d'un système de réservation d'activités**

### **Utilisation d'api platform**

#### **Installation**
* entrer sa cfg database du .env.local
* composer install
* symfony (php bin/console) d:d:c
* symfony d:m:m (yes)
* symfony d:f:l (yes)
* symfony serve 
* l'api est à URL/api

###  **TO DO** 💻
1. Classe `Activity` représentant une activité (nom, capacité max, plage d'horaires).
2. Classe `Booking` représentant une réservation (nom, activité choisie, heure souhaitée, nombre de participants).
3. Classe `BookingManager` qui gère les réservations.
4. Utiliser un formulaire et gérer l'affichage des réservations.
5. Faire des dataFixtures
6. Mise en place d'une API avec api platform

---

## **Consignes**

### **Règles de l'exo**
✅ Respect des règles métier  
✅ Gestion des erreurs via des exceptions personnalisées  
✅ Code propre et bien structuré  
✅ Bonne utilisation des types PHP 8 (`private`, `readonly`, `string`, `int`)  

### **Contexte**
Une entreprise propose différentes **activités sportives** (ex: Surf, Escalade, Parapente) que les utilisateurs peuvent réserver. 

### **Contraintes Métier**
1. **Vérification de la disponibilité** : Une réservation ne doit être acceptée que si l'heure demandée est dans la plage horaire de l'activité.
2. **Capacité respectée** : Une activité ne peut pas accepter plus de participants que la limite définie.
3. **Interdiction des doublons** : Un même utilisateur ne peut pas réserver la même activité à la même heure.
4. **Historisation des réservations** : Stockez les réservations et affichez-les après chaque nouvelle réservation.
5. **Gestion des erreurs avec exceptions** : Si une règle métier n'est pas respectée, lever une exception personnalisée.

---

### **Code de Départ**
Compléter les méthodes en respectant les contraintes métier.

```php
<?php

class Activity {
    public function __construct(
        private string $name,
        private int $maxCapacity,
        private string $startTime,
        private string $endTime
    ) {}
    // TODO: Getters et Setters
}

class Booking {
    public function __construct(
        private string $userName,
        private Activity $activity,
        private string $bookingTime,
        private int $participants
    ) {}
    // TODO: Getters et Setters
}

class BookingManager {
    private array $bookings = [];

    public function addBooking(Booking $booking): void {
        // TODO: Vérifier la disponibilité
        // TODO: Vérifier la capacité
        // TODO: Vérifier les doublons
        // TODO: Ajouter la réservation
    }

    public function listBookings(): void {
        // TODO: Afficher toutes les réservations existantes
    }
}

// TODO: Simulez quelques activités, testez la réservation et persistance en bdd

$surf = new Activity("Surf", 10, "09:00", "18:00");
$parapente = new Activity("Parapente", 5, "10:00", "16:00");

$manager = new BookingManager();