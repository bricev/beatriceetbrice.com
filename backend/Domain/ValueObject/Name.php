<?php

namespace Wedding\Domain\ValueObject;

final class Name implements \JsonSerializable
{
    private $value;

    /**
     *
     * @param $value
     */
    public function __construct(string $value)
    {
        if (!$value) {
            throw new \RuntimeException("Name $value is not valid");
        }

        $this->value = $value;
    }

    /**
     *
     * @return string
     */
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
