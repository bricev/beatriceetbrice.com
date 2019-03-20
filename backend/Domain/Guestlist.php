<?php

namespace Wedding\Domain;

use Wedding\Domain\ValueObject\Identifier;
use Wedding\Domain\ValueObject\Name;

interface Guestlist
{
    public function register(Group $group);
    public function findGroup(Identifier $identifier): ?Group;
    public function findGroupByName(Name $name): ?Group;
    public function findGuest(Name $name): ?Guest;
    public function findGroupByGuest(Guest $guest): ?Group;
}
