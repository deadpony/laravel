<?php

namespace App\Components\Vault\Outbound\Services\Collector;

use App\Components\Vault\Outbound\Wallet\WalletDTO;

interface CollectorServiceContract
{
    /**
     * @param string $type
     * @param float $amount
     * @return WalletDTO
     */
    public function collect(string $type, float $amount): WalletDTO;

    /**
     * @param string $identity
     * @param float $amount
     * @return WalletDTO
     */
    public function change(string $identity, float $amount): WalletDTO;

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool;

    /**
     * @param string $identity
     * @return WalletDTO
     */
    public function view(string $identity): WalletDTO;
}