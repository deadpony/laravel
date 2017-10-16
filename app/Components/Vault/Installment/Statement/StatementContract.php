<?php

namespace App\Components\Vault\Installment\Statement;

use App\Components\Vault\Installment\Statement\Term\TermContract;
use App\Convention\ValueObjects\Identity\Identity;

interface StatementContract
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
     * @return \DateTime
     */
    public function createdAt(): \DateTime;

    /**
     * @return TermContract|null
     */
    public function term();

    /**
     * @param TermContract $term
     * @return StatementContract
     */
    public function assignTerm(TermContract $term): StatementContract;

    /**
     * @param float $amount
     * @return StatementContract
     */
    public function updateAmount(float $amount): StatementContract;
}