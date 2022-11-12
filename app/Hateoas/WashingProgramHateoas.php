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

    public function store(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.store", []);
    }

    public function statusAll(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.statusAll", []);
    }

    public function status(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.status", ['washing_program' => $washingProgram]);
    }

    public function update(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.update", ['washing_program' => $washingProgram]);
    }

    public function destroy(WashingProgram $washingProgram) : ?Link
    {
        return $this->link("washing_program.destroy", ['washing_program' => $washingProgram]);
    }
}
