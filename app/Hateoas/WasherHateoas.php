<?php

namespace App\Hateoas;

use App\Models\Washer;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class WasherHateoas
{
    use CreatesLinks;

    public function self() : ?Link
    {
        return $this->link("washer.index", []);
    }

    public function store() : ?Link
    {
        return $this->link("washer.store", []);
    }

    public function statusAll() : ?Link
    {
        return $this->link("washer.statusAll", []);
    }

    public function status(Washer $washer) : ?Link
    {
        return $this->link("washer.status", ['washer' => $washer]);
    }

    public function destroy(Washer $washer) : ?Link
    {
        return $this->link("washer.destroy", ['washer' => $washer]);
    }
}
