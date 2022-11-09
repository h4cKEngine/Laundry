<?php

namespace App\Hateoas;

use App\Models\WashingProgram;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class WashingProgramHateoas
{
    use CreatesLinks;

    public function self(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.index", []);
    }
}
