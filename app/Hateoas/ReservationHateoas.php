<?php

namespace App\Hateoas;

use App\Models\Reservation;
use App\Models\User;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class ReservationHateoas
{
    use CreatesLinks;

    public function self(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.show", ['reservation' => $reservation, 'user' => $reservation->utente->id]);
    }

    public function showReservation(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.showReservation", ['user' => $reservation->utente->id]);
    }
}
