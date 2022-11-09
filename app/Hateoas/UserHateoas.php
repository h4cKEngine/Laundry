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
        return $this->link("user.show", ['user' => $user]); // user. route della categoria --- show funzione della route --- ['user' => $user] parametro passato dalla route
    }

}
