<?php

namespace App\Hateoas;

use App\Models\Reservation;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class ReservationHateoas
{
    use CreatesLinks;

    public function self(Reservation $reservation) : ?Link
    {
        //
    }
}
