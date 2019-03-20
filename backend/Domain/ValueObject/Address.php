<?php

namespace Wedding\Domain\ValueObject;

final class Address
{
    private $value;

    /**
     *
     * @param $value
     */
    public function __construct($value)
    {
        if ('' === $value = trim((string) $value)) {
            $value = null;
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
