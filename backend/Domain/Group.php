<?php

namespace Wedding\Domain;

use Wedding\Domain\ValueObject\Address;
use Wedding\Domain\ValueObject\Email;
use Wedding\Domain\ValueObject\Identifier;
use Wedding\Domain\ValueObject\Name;

final class Group implements \Countable, \JsonSerializable
{
    /** @var Identifier */
    private $identifier;

    /** @var Name */
    private $name;

    /** @var Email */
    private $email;

    /** @var Address */
    private $address;

    /** @var Guest[] */
    private $guests = [];

    /**
     *
     * @param Identifier $identifier
     * @param Name $name
     * @param Email $email
     * @param Address $address
     * @param array $guests
     */
    public function __construct(Identifier $identifier, Name $name, Email $email, ?Address $address, array $guests = [])
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;

        foreach ($guests as $guest) {
            $this->addGuest($guest);
        }
    }

    /**
     *
     * @return Identifier
     */
    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }

    /**
     *
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     *
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     *
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     *
     * @param Guest $guest
     */
    private function addGuest(Guest $guest)
    {
        if ((string) $guest->getGroupIdentifier() !== (string) $this->identifier) {
            throw new \RuntimeException(sprintf('Guest "%s" do not match group "%s"',
                $guest->getGroupIdentifier(),
                $this->identifier));
        }

        $this->guests[] = $guest;
    }

    /**
     *
     * @return Guest[]
     */
    public function getGuests(): array
    {
        return $this->guests;
    }

    /**
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->guests);
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    function jsonSerialize()
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name,
            'guests' => $this->guests,
        ];
    }
}
