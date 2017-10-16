<?php

namespace App\Components\Vault\Inbound\Services\Collector;

interface CollectorServiceContract
{
    /**
     * @param string $type
     * @param float $amount
     * @return string
     */
    public function collect(string $type, float $amount): string;

    /**
     * @param string $identity
     * @param float $amount
     * @return string
     */
    public function change(string $identity, float $amount): string;

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool;

    /**
     * @param string $identity
     * @return array
     */
    public function view(string $identity): array;
}