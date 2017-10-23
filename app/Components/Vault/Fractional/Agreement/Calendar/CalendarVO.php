<?php

namespace App\Components\Vault\Fractional\Agreement\Calendar;

class CalendarVO
{
    /**
     * @var int
     */
    private $serialNumber;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param \DateTime $date
     */
    public function __construct(int $serialNumber, \DateTime $date)
    {
        if (!$serialNumber > 0) {
            throw new \InvalidArgumentException("Serial Number should be greater than zero");
        }

        $this->serialNumber = $serialNumber;
        $this->date = $date;
    }

    public function serialNumber(): int
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function year(): string
    {
        return $this->date->format('Y');
    }

    /**
     * @return string
     */
    public function month(): string
    {
        return $this->date->format('m');
    }

    /**
     * @return string
     */
    public function deadlineDate(): string
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->deadlineDate();
    }

    /**
     * @param CalendarVO $date
     * @return bool
     */
    public function equals(CalendarVO $date): bool
    {
        return (new \DateTime($this->deadlineDate())) === (new \DateTime($date->deadlineDate()));
    }
}