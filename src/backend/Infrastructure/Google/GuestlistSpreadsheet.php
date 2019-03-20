<?php

namespace Wedding\Infrastructure\Google;

use Wedding\Domain\Group;
use Wedding\Domain\Guest;
use Wedding\Domain\Guestlist;
use Wedding\Domain\ValueObject\Address;
use Wedding\Domain\ValueObject\Age;
use Wedding\Domain\ValueObject\Email;
use Wedding\Domain\ValueObject\Identifier;
use Wedding\Domain\ValueObject\Name;
use Wedding\Domain\ValueObject\Sex;

final class GuestlistSpreadsheet extends GoogleSpreadsheet implements Guestlist
{
    /** @var Group[] */
    private $groups = [];

    /** @var Guest[] */
    private $guests = [];

    /** @var array */
    private $groupIdentifierMap = [];

    /**
     *
     * @param Group $group
     * @todo not used yet
     */
    public function register(Group $group) {}

    /**
     *
     * @param Identifier $identifier
     * @return null|Group
     */
    public function findGroup(Identifier $identifier): ?Group
    {
        if (!isset($this->getGroups()[(string) $identifier]) or !$group = $this->getGroups()[(string) $identifier]) {
            return null;
        }

        return $group;
    }

    /**
     *
     * @param Name $name
     * @return null|Group
     */
    public function findGroupByName(Name $name): ?Group
    {
        foreach ($this->getGroups() as $group) {
            if ((string) $name === (string) $group->getName()) {
                return $group;
            }
        }

        return null;
    }

    /**
     *
     * @param Name $name
     * @return null|Guest
     */
    public function findGuest(Name $name): ?Guest
    {
        foreach ($this->getGuests() as $guest) {
            if ((string) $name === (string) $guest->getName()) {
                return $guest;
            }
        }

        return null;
    }

    /**
     *
     * @param Guest $guest
     * @return null|Group
     */
    public function findGroupByGuest(Guest $guest): ?Group
    {
        return $this->findGroup(
            $guest->getGroupIdentifier()
        );
    }

    /**
     *
     * @return Group[]
     */
    private function getGroups(): array
    {
        if (!empty($this->groups)) {
            return $this->groups;
        }

        $entries = $this
            ->service
            ->spreadsheets_values
            ->get($this->spreadSheetId, self::RANGE_GROUP)
            ->getValues();

        foreach ($entries as $entry) {
            list($identifier, $name, $email, $address) = $entry;

            $identifier = new Identifier($identifier);

            // Collect all guests from the group
            $guests = [];
            foreach ($this->getGuests() as $guest) {
                if ((string) $identifier === (string) $guest->getGroupIdentifier()) {
                    $guests[] = $guest;
                }
            }

            $this->groups[(string) $identifier] = new Group(
                $identifier,
                new Name($name),
                new Email($email),
                new Address((string) $address),
                $guests
            );
        }

        return $this->groups;
    }

    /**
     *
     * @return Guest[]
     */
    private function getGuests(): array
    {
        if (!empty($this->guests)) {
            return $this->guests;
        }

        $entries = $this
            ->service
            ->spreadsheets_values
            ->get($this->spreadSheetId, self::RANGE_GUEST)
            ->getValues();

        foreach ($entries as $entry) {
            list($name, $groupName, $email, $sex, $age) = $entry;

            $this->guests[] = new Guest(
                new Name($name),
                $this->getGroupIdentifierFromName($groupName),
                Sex::build($sex),
                Age::build($age),
                new Email($email)
            );
        }

        return $this->guests;
    }

    /**
     *
     * @param $groupName
     * @return null|Identifier
     * @throws \Exception
     */
    private function getGroupIdentifierFromName($groupName): ?Identifier
    {
        if (empty($this->groupIdentifierMap)) {

            $entries = $this
                ->service
                ->spreadsheets_values
                ->get($this->spreadSheetId, self::RANGE_GROUP)
                ->getValues();

            foreach ($entries as $entry) {
                list($identifier, $name) = $entry;
                $this->groupIdentifierMap[$identifier] = $name;
            }
        }

        if ($groupId = array_search($groupName, $this->groupIdentifierMap)) {
            return new Identifier($groupId);
        }

        throw new \Exception(sprintf('Impossible to find "%s" group', $groupName));
    }
}
