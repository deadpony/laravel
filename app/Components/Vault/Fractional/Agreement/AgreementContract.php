<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Outbound\Wallet\WalletContract;
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
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface;

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
     * @param WalletContract $payment
     * @return bool
     */
    public function pay(WalletContract $payment): bool;

    /**
     * @param WalletContract $payment
     * @return bool
     */
    public function refund(WalletContract $payment): bool;

    /**
     * @param float $amount
     * @return AgreementContract
     */
    public function updateAmount(float $amount): AgreementContract;

    /**
     * @return bool
     */
    public function isDeadlineReached(): bool;

    /**
     * @return bool
     */
    public function isDeadlinePassed(): bool;

    /**
     * @return bool
     */
    public function isAgreementPassed(): bool;
}