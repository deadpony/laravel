<?php

namespace App\Components\Vault\Inbound\Services\Collector;

use App\Components\Vault\Inbound\Payment\PaymentDTO;

interface CollectorServiceContract
{
    /**
     * @param string $type
     * @param float $amount
     * @return PaymentDTO
     */
    public function collect(string $type, float $amount): PaymentDTO;

    /**
     * @param string $identity
     * @param float $amount
     * @return PaymentDTO
     */
    public function change(string $identity, float $amount): PaymentDTO;

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool;

    /**
     * @param string $identity
     * @return PaymentDTO
     */
    public function view(string $identity): PaymentDTO;
}