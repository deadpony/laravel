<?php

namespace App\Components\Vault\Incoming\Statement;

use App\Components\Vault\Incoming\Statement\Account\TermContract;
use App\Convention\ValueObjects\DateTime\DateTime;
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
     * @return DateTime
     */
    public function createdAt(): DateTime;

    /**
     * @return TermContract|null
     */
    public function term();
}