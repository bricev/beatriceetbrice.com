<?php

namespace Wedding\Domain\ValueObject;

final class Sex implements \JsonSerializable
{
    const
        FEMALE = 'f',
        MALE = 'm';

    /** @var string */
    private $value;

    /**
     *
     * @param $value
     */
    public function __construct(string $value)
    {
        if (!in_array($value, [self::FEMALE, self::MALE])) {
            throw new \RuntimeException("Invalid sex '$value'");
        }

        $this->value = $value;
    }

    /**
     *
     * @return bool
     */
    public function isFemale(): bool
    {
        return self::FEMALE === $this->value;
    }

    /**
     *
     * @return bool
     */
    public function isMale(): bool
    {
        return !$this->isFemale();
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
     * @param string $string
     * @return Sex
     */
    public static function build(string $string): self
    {
        switch ($string) {
            case 'Woman':
            case 'Girl':
            case 'Femme':
            case 'F':
            case 'f':
                return new self(self::FEMALE);

            default:
                return new self(self::MALE);
        }

    }
}
