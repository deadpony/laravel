<?php

namespace App\Components\Vault\Outbound\Wallet;

use App\Convention\ValueObjects\Identity\Identity;

interface WalletContract
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
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface;

    /**
     * @param float $amount
     * @return WalletContract
     */
    public function updateAmount(float $amount): WalletContract;
}