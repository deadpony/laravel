<?php

namespace App\Components\Vault\Fractional\Agreement\Term;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Convention\ValueObjects\Identity\Identity;

interface TermContract
{
    /**
     * @return Identity
     */
    public function id(): Identity;

    /**
     * @return int
     */
    public function months(): int;

    /**
     * @return int
     */
    public function deadlineDay(): int;

    /**
     * @return float
     */
    public function setupFee(): float;

    /**
     * @return float
     */
    public function monthlyFee(): float;

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime;

    /**
     * @return AgreementContract
     */
    public function agreement(): AgreementContract;

    /**
     * @param int $months
     * @return TermContract
     */
    public function updateMonths(int $months): TermContract;

    /**
     * @param int $day
     * @return TermContract
     */
    public function updateDeadlineDay(int $day): TermContract;

    /**
     * @param float $setupFee
     * @return TermContract
     */
    public function updateSetupFee(float $setupFee): TermContract;

    /**
     * @param float $monthlyFee
     * @return TermContract
     */
    public function updateMonthlyFee(float $monthlyFee): TermContract;
}