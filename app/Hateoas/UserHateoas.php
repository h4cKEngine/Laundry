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
        // user. route della categoria --- show funzione della route --- ['user' => $user] parametro passato dalla route
        return $this->link("user.show", ['user' => $user]); 
    }

    public function index(User $user) : ?Link
    {
        return $this->link("user.indexUser", ['user' => $user]); 
    }

    public function deletePrenAll(User $user) : ?Link
    {
        return $this->link("user.reservation.deletePrenAll", ['user' => $user]);
    }
}
