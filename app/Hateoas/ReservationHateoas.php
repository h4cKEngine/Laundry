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

    public function index(Reservation $reservation) : ?Link
    {
        return $this->link("user.indexReservation", ['reservation' => $reservation, 'user' => $reservation->utente->id]);
    }

    public function showReservationsUser(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.showReservationsUser", ['user' => $reservation->utente->id]);
    }

    public function store(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.store", ['reservation' => $reservation, 'user' => $reservation->utente->id]);
    }

    public function update(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.update", ['reservation' => $reservation, 'user' => $reservation->utente->id]);
    }

    public function destroy(Reservation $reservation) : ?Link
    {
        return $this->link("user.reservation.destroy", ['user' => $reservation->utente->id, 'reservation' => $reservation]);
    }

}
