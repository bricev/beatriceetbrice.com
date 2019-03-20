<?php

namespace Wedding\Domain\ValueObject;

final class Age implements \JsonSerializable
{
    const
        BABY = 0,
        CHILD = 1,
        ADULT = 2;

    /** @var int */
    private $value;

    /**
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        if (!in_array($value, [0, 1, 2])) {
            throw new \RuntimeException('Invalid age');
        }

        $this->value = $value;
    }

    /**
     *
     * @return bool
     */
    public function isBaby(): bool
    {
        return self::BABY === $this->value;
    }

    /**
     *
     * @return bool
     */
    public function isChild(): bool
    {
        return self::CHILD === $this->value;
    }

    /**
     *
     * @return bool
     */
    public function isAdult(): bool
    {
        return self::ADULT === $this->value;
    }

    /**
     *
     * @return int
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     *
     * @param string $string
     * @return Age
     */
    public static function build(string $string): self
    {
        switch ($string) {
            case 'Baby':
            case 'Bébé':
                return new self(self::BABY);

            case 'Child':
            case 'Enfant':
                return new self(self::CHILD);

            default: return new self(self::ADULT);
        }
    }
}
