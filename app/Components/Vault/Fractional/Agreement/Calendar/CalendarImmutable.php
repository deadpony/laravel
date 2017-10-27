<?php

namespace App\Components\Vault\Fractional\Agreement\Calendar;

class CalendarImmutable
{
    /**
     * @var \DateTime
     */
    private $beginningDate;

    /**
     * @var \DateTime
     */
    private $deadlineDate;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date, int $deadlineDay)
    {
        $this->deadlineDate = new \DateTime($date->format('Y-m-d H:i:s'));

        $this->deadlineDate
            ->modify("first day of this month")
            ->modify("+ {$deadlineDay} day")
            ->modify("- 1 day")
            ->setTime(23, 59, 59);

        $this->beginningDate = new \DateTime($this->deadlineDate->format('Y-m-d H:i:s'));

        $this->beginningDate->modify("first day of this month")->setTime(0, 0, 0);
    }

    /**
     * @return string
     */
    public function beginningDate(): string
    {
        return $this->beginningDate->format('Y-m-d');
    }

    /**
     * @return int
     */
    public function beginningTimestamp(): int
    {
        return $this->beginningDate->getTimestamp();
    }

    /**
     * @return string
     */
    public function deadlineDate(): string
    {
        return $this->deadlineDate->format('Y-m-d');
    }

    /**
     * @return int
     */
    public function deadlineTimestamp(): int
    {
        return $this->deadlineDate->getTimestamp();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->deadlineDate();
    }

    /**
     * @param CalendarImmutable $date
     * @return bool
     */
    public function equals(CalendarImmutable $date): bool
    {
        return $this->deadlineTimestamp() === $date->deadlineTimestamp();
    }

    /**
     * @param CalendarImmutable $date
     * @return bool
     */
    public function gt(CalendarImmutable $date): bool
    {
        return $this->deadlineTimestamp() > $date->deadlineTimestamp();
    }

    /**
     * @param CalendarImmutable $date
     * @return bool
     */
    public function lt(CalendarImmutable $date): bool
    {
        return $this->deadlineTimestamp() < $date->deadlineTimestamp();
    }

    /**
     * @param CalendarImmutable $date
     * @return int
     */
    public function diffDeadlineMonths(CalendarImmutable $date): int
    {
        return $this->deadlineDate->diff(new \DateTime($date->deadlineDate()), true)->m;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function inRange(\DateTime $date): bool
    {
        return $date <= $this->deadlineDate && $date >= $this->beginningDate;
    }
}