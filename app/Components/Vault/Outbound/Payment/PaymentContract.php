<?php

namespace App\Components\Vault\Outbound\Payment;

use App\Convention\ValueObjects\Identity\Identity;

interface PaymentContract
{
    /**
     * @return Identity
     */
    public function id(): Identity;

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return float
     */
    public function amount(): float;

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime;

    /**
     * @param float $amount
     * @return PaymentContract
     */
    public function updateAmount(float $amount): PaymentContract;
}