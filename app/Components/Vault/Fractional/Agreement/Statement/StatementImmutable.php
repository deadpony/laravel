<?php

namespace App\Components\Vault\Fractional\Agreement\Statement;

use App\Components\Vault\Fractional\Agreement\Calendar\CalendarImmutable;
use App\Components\Vault\Outbound\Payment\PaymentContract;

class StatementImmutable
{
    /**
     * @var CalendarImmutable
     */
    private $calendarDate;

    /**
     * @var bool
     */
    private $overdue;

    /**
     * @var float
     */
    private $basePayment;

    /**
     * @var float
     */
    private $definedPayment;

    /**
     * @var float
     */
    private $leftoverPayment;

    /**
     * @var float
     */
    private $fee;

    /**
     * @var array
     */
    private $payments = [];


    /**
     * @param CalendarImmutable $calendarDate
     * @param float $basePayment
     * @param float $definedPayment
     * @param float $leftoverPayment
     * @param bool $overdue
     * @param float $fee
     * @param array $payments
     */
    public function __construct(
        CalendarImmutable $calendarDate,
        float $basePayment,
        float $definedPayment,
        float $leftoverPayment,
        bool $overdue,
        float $fee,
        array $payments
    ) {
        $this->calendarDate = $calendarDate;

        if (!$basePayment > 0) {
            throw new \InvalidArgumentException("Base payment value should be more than zero value");
        }

        $this->basePayment = $basePayment;
        $this->definedPayment = $definedPayment;
        $this->leftoverPayment = $leftoverPayment;

        $this->fee = $fee;

        $this->overdue = $overdue;

        collect($payments)->each(function (PaymentContract $payment) {
            $this->payments[] = $payment;
        });
    }

    /**
     * @return CalendarImmutable
     */
    public function calendarDate(): CalendarImmutable
    {
        return $this->calendarDate;
    }

    /**
     * @return float
     */
    public function basePayment(): float
    {
        return $this->basePayment;
    }

    /**
     * @return float
     */
    public function definedPayment(): float
    {
        return $this->definedPayment;
    }

    /**
     * @return float
     */
    public function leftoverPayment(): float
    {
        return $this->leftoverPayment;
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
        return sha1((string)$this->calendarDate() . $this->basePayment());
    }

    /**
     * @param CalendarImmutable $date
     * @return bool
     */
    public function equals(CalendarImmutable $date): bool
    {
        return strtolower((string)$this) === strtolower((string)$date);
    }
}