<?php

namespace Wedding\Domain;

use Wedding\Domain\ValueObject\Identifier;

final class Rsvp implements \JsonSerializable
{
    /** @var Identifier */
    private $groupIdentifier;

    /** @var Guest[] */
    private $comingGuests = [];

    /** @var bool */
    private $needBabysitter = false;

    /** @var bool */
    private $needDriver = false;

    /** @var bool */
    private $hasAllergy = false;

    /** @var string */
    private $favorite60sTube;

    /** @var string */
    private $favorite70sTube;

    /** @var string */
    private $favorite80sTube;

    /** @var  */
    private $favoriteContemporaryTube;

    /**
     *
     * @param Identifier $groupIdentifier
     * @param array $comingGuests
     * @param bool $needBabysitter
     * @param bool $needDriver
     * @param bool $hasAllergy
     * @param string $favorite60sTube
     * @param string $favorite70sTube
     * @param string $favorite80sTube
     * @param string $favoriteContemporaryTube
     */
    public function __construct(
        Identifier $groupIdentifier,
        array $comingGuests,
        bool $needBabysitter,
        bool $needDriver,
        bool $hasAllergy,
        ?string $favorite60sTube,
        ?string $favorite70sTube,
        ?string $favorite80sTube,
        ?string $favoriteContemporaryTube
    ){
        $this->groupIdentifier = $groupIdentifier;
        $this->needBabysitter = $needBabysitter;
        $this->needDriver = $needDriver;
        $this->hasAllergy = $hasAllergy;
        $this->favorite60sTube = $favorite60sTube;
        $this->favorite70sTube = $favorite70sTube;
        $this->favorite80sTube = $favorite80sTube;
        $this->favoriteContemporaryTube = $favoriteContemporaryTube;

        foreach ($comingGuests as $guest) {
            $this->addGuest($guest);
        }
    }

    /**
     *
     * @return Identifier
     */
    public function getGroupIdentifier(): Identifier
    {
        return $this->groupIdentifier;
    }

    /**
     *
     * @param Guest $guest
     */
    private function addGuest(Guest $guest)
    {
        $this->comingGuests[] = $guest;
    }

    /**
     *
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'groupIdentifier' => (string) $this->groupIdentifier,
            'comingGuests' => implode(PHP_EOL, array_map('strval', $this->comingGuests)),
            'needBabysitter' => $this->needBabysitter ? 'OUI' : 'NON',
            'needDriver' => $this->needDriver ? 'OUI' : 'NON',
            'hasAllergy' => $this->hasAllergy ? 'OUI' : 'NON',
            'favorite60sTube' => $this->favorite60sTube,
            'favorite70sTube' => $this->favorite70sTube,
            'favorite80sTube' => $this->favorite80sTube,
            'favoriteContemporaryTube' => $this->favoriteContemporaryTube,
        ];
    }

    function jsonSerialize()
    {
        return [
            'comingGuests' => $this->comingGuests,
            'needBabysitter' => $this->needBabysitter,
            'needDriver' => $this->needDriver,
            'hasAllergy' => $this->hasAllergy,
            'favorite60sTube' => $this->favorite60sTube,
            'favorite70sTube' => $this->favorite70sTube,
            'favorite80sTube' => $this->favorite80sTube,
            'favoriteContemporaryTube' => $this->favoriteContemporaryTube,
        ];
    }
}
