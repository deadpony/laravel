<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermContract;
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
     * @return \DateTime
     */
    public function createdAt(): \DateTime;

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
     * @param float $amount
     * @return AgreementContract
     */
    public function updateAmount(float $amount): AgreementContract;
}