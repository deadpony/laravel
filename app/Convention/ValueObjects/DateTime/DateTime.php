<?php

namespace App\Convention\ValueObjects\DateTime;

final class DateTime
{
    /**
     * @var string
     */
    private $datetime;

    /**
     * @param string $datetime
     * @throws \InvalidArgumentException
     */
    public function __construct(string $datetime)
    {
        if (\DateTime::createFromFormat('Y-m-d H:i:s', $datetime) === false) {
            throw new \InvalidArgumentException("Incorrect DateTime format, should be Y-m-d H:i:s");
        }

        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function datetime() {
        return $this->datetime;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->datetime();
    }

    /**
     * @param DateTime $datetime
     * @return bool
     */
    public function equals(DateTime $datetime)
    {
        return strtolower((string) $this) === strtolower((string) $datetime);
    }
}