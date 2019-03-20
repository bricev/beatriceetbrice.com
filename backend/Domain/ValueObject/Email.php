<?php

namespace Wedding\Domain\ValueObject;

final class Email
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

        if (!is_null($value) and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException("Email $value is not valid");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
