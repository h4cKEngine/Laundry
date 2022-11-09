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
}
