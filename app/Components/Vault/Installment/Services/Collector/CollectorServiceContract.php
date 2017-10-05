<?php

namespace App\Components\Vault\Installment\Services\Collector;

interface CollectorServiceContract
{
    /**
     * @param float $amount
     * @return string
     */
    public function signStatement(float $amount): string;

    /**
     * @param string $identity
     * @param float $amount
     * @return string
     */
    public function resignStatement(string $identity, float $amount): string;

    /**
     * @param string $identity
     * @return bool
     */
    public function rollbackStatement(string $identity): bool;

    /**
     * @param string $identity
     * @return array
     */
    public function viewStatement(string $identity): array;

    /**
     * @param int $months
     * @param int $paymentDeadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @return CollectorServiceContract
     */
    public function signTerm(int $months, int $paymentDeadlineDay, float $setupFee = 0.00, float $monthlyFee = 0.00): CollectorServiceContract;
}