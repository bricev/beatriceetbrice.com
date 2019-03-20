<?php

namespace Wedding\Domain\ValueObject;

final class Identifier implements \JsonSerializable
{
    private $value;

    /**
     *
     * @param $value
     */
    public function __construct($value)
    {
        $value = trim((string) $value);

        if (!$value) {
            throw new \RuntimeException("Identifier $value is not valid");
        }

        $this->value = $value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
