<?php

namespace App\Components\Vault\Fractional\Services\Collector;

interface CollectorServiceContract
{
    /**
     * @param float $amount
     * @return string
     */
    public function collect(float $amount): string;

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

    /**
     * @param int $months
     * @param int $paymentDeadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @return CollectorServiceContract
     */
    public function assignTerm(int $months, int $paymentDeadlineDay, float $setupFee = 0.00, float $monthlyFee = 0.00): CollectorServiceContract;
}