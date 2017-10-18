<?php

namespace App\Components\Vault\Fractional\Services\Collector;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;

interface CollectorServiceContract
{
    /**
     * @param float $amount
     * @return AgreementDTO
     */
    public function collect(float $amount): AgreementDTO;

    /**
     * @param string $identity
     * @param float $amount
     * @return AgreementDTO
     */
    public function change(string $identity, float $amount): AgreementDTO;

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool;

    /**
     * @param string $identity
     * @return AgreementDTO
     */
    public function view(string $identity): AgreementDTO;

    /**
     * @param int $months
     * @param int $paymentDeadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @return CollectorServiceContract
     */
    public function assignTerm(int $months, int $paymentDeadlineDay, float $setupFee = 0.00, float $monthlyFee = 0.00): CollectorServiceContract;
}