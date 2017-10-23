<?php

namespace App\Components\Vault\Fractional\Agreement\Statement;

use App\Components\Vault\Fractional\Agreement\Calendar\CalendarVO;
use App\Components\Vault\Outbound\Payment\PaymentContract;

class StatementVO
{
    /**
     * @var CalendarVO
     */
    private $calendarDate;

    /**
     * @var bool
     */
    private $paid;

    /**
     * @var bool
     */
    private $overdue;

    /**
     * @var float
     */
    private $initial;

    /**
     * @var float
     */
    private $leftover;

    /**
     * @var float
     */
    private $fee;

    /**
     * @var array
     */
    private $payments = [];

    /**
     * @param bool $paid
     * @param bool $overdue
     * @param float $leftover
     * @param float $fee
     * @param array $payments
     */
    public function __construct(
        CalendarVO $calendarDate,
        bool $paid,
        bool $overdue,
        float $initial,
        float $leftover,
        float $fee,
        array $payments
    ) {
        $this->calendarDate = $calendarDate;
        $this->paid = $paid;
        $this->overdue = $overdue;

        if (!$initial > 0) {
            throw new \InvalidArgumentException("Initial value should be more than zero value");
        }

        $this->initial = $initial;
        $this->leftover = $leftover;
        $this->fee = $fee;

        collect($payments)->each(function (PaymentContract $payment) {
            $this->payments[] = $payment;
        });
    }

    /**
     * @return CalendarVO
     */
    public function calendarDate(): CalendarVO
    {
        return $this->calendarDate;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->paid;
    }

    /**
     * @return bool
     */
    public function isOverdue(): bool
    {
        return $this->overdue;
    }

    /**
     * @return float
     */
    public function initial(): float
    {
        return $this->initial;
    }

    /**
     * @return float
     */
    public function leftover(): float
    {
        return $this->leftover;
    }

    /**
     * @return float
     */
    public function fee(): float
    {
        return $this->fee;
    }

    /**
     * @return array
     */
    public function payments(): array
    {
        return $this->payments;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sha1((string)$this->calendarDate() . $this->initial());
    }

    /**
     * @param CalendarVO $date
     * @return bool
     */
    public function equals(CalendarVO $date): bool
    {
        return strtolower((string)$this) === strtolower((string)$date);
    }
}