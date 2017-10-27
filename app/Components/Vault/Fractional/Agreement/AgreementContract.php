<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Fractional\Agreement\Calendar\CalendarImmutable;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Convention\ValueObjects\Identity\Identity;

interface AgreementContract
{
    /**
     * @return Identity
     */
    public function id(): Identity;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime;

    /**
     * @return TermContract|null
     */
    public function term();

    /**
     * @param TermContract $term
     * @return AgreementContract
     */
    public function assignTerm(TermContract $term): AgreementContract;

    /**
     * @return array
     */
    public function payments(): array;

    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function pay(PaymentContract $payment): bool;

    /**
     * @return PaymentContract
     */
    public function lastPayment(): PaymentContract;

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByMonthlyDeadline(CalendarImmutable $deadlineDate): array;

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByBoundaryDeadline(CalendarImmutable $deadlineDate): array;

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByBoundaryBeginning(CalendarImmutable $deadlineDate): array;

    /**
     * @param array $payments
     * @return float
     */
    public function totalPaid(array $payments = []): float;

    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function refund(PaymentContract $payment): bool;

    /**
     * @param float $amount
     * @return AgreementContract
     */
    public function updateAmount(float $amount): AgreementContract;

    /**
     * @return float
     */
    public function basePayment(): float;

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function definedPayment(CalendarImmutable $calendarDeadlineDate): float;

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function leftoverPayment(CalendarImmutable $calendarDeadlineDate): float;

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function overdraftPayment(CalendarImmutable $calendarDeadlineDate): float;

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return bool
     */
    public function isDeadlineReached(CalendarImmutable $calendarDeadlineDate): bool;

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return bool
     */
    public function isDeadlinePassed(CalendarImmutable $calendarDeadlineDate): bool;

    /**
     * @return bool
     */
    public function isAgreementPassed(): bool;

    /**
     * @return array
     */
    public function statements(): array;
}