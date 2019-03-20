<?php

namespace Wedding\Domain;

use Wedding\Domain\ValueObject\Age;
use Wedding\Domain\ValueObject\Email;
use Wedding\Domain\ValueObject\Identifier;
use Wedding\Domain\ValueObject\Name;
use Wedding\Domain\ValueObject\Sex;

final class Guest implements \JsonSerializable
{
    /** @var Name */
    private $name;

    /** @var Identifier */
    private $groupIdentifier;

    /** @var Sex */
    private $sex;

    /** @var Age */
    private $age;

    /** @var Email */
    private $email;

    /** @var Rsvp */
    private $rsvp;

    /**
     *
     * @param Name       $name
     * @param Identifier $groupIdentifier
     * @param Sex        $sex
     * @param Age        $age
     * @param Email      $email
     * @param Rsvp       $rsvp
     */
    public function __construct(
        Name $name,
        Identifier $groupIdentifier,
        Sex $sex,
        Age $age,
        ?Email $email,
        Rsvp $rsvp = null
    ){
        $this->name = $name;
        $this->groupIdentifier = $groupIdentifier;
        $this->sex = $sex;
        $this->age = $age;
        $this->email = $email;
        $this->rsvp = $rsvp;
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
     * @return Identifier
     */
    public function getGroupIdentifier(): Identifier
    {
        return $this->groupIdentifier;
    }

    /**
     *
     * @return Sex
     */
    public function getSex(): Sex
    {
        return $this->sex;
    }

    /**
     *
     * @return Age
     */
    public function getAge(): Age
    {
        return $this->age;
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
     * @return Rsvp
     */
    public function getRsvp(): Rsvp
    {
        return $this->rsvp;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     *
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'sex' => $this->sex,
            'age' => $this->age,
        ];
    }}
