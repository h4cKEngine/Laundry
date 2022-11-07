<?php

namespace App\Hateoas;

use App\Models\User;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class UserHateoas
{
    use CreatesLinks;

    public function self(User $user) : ?Link
    {
        //
    }
}
