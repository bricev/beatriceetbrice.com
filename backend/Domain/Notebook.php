<?php

namespace Wedding\Domain;

use Wedding\Domain\ValueObject\Identifier;

interface Notebook
{
    public function register(Rsvp $rsvp);
    public function find(Identifier $groupId, Guestlist $guestlist): ?Rsvp;
}
