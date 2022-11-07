<?php

namespace App\Hateoas;

use App\Models\Message;
use App\Models\Washer;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class MessageHateoas
{
    use CreatesLinks;

    public function self(Message $message) : ?Link
    {
        //
    }
}
