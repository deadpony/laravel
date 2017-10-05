<?php

namespace App\Components\Vault\Incoming\Statement\Term;

use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Convention\ValueObjects\DateTime\DateTime;
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
     * @return DateTime
     */
    public function createdAt(): DateTime;

    /**
     * @return StatementContract
     */
    public function statement(): StatementContract;
}