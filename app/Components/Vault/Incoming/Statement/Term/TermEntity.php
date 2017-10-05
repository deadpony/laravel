<?php

namespace App\Components\Vault\Incoming\Statement\Term;

use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Convention\ValueObjects\DateTime\DateTime;
use App\Convention\ValueObjects\Identity\Identity;

class TermEntity implements TermContract
{
    /**
     * @var Identity
     */
    private $id;
    /**
     * @var int
     */
    private $months;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var StatementContract
     */
    private $statement;

    /**
     * @param Identity $id
     * @param int $months
     * @param StatementContract $statement
     */
    public function __construct(Identity $id, int $months, StatementContract $statement)
    {
        $this->id = $id;
        $this->setMonths($months);

        $this->statement = $statement;

        $this->createdAt = new DateTime(new \DateTimeImmutable());
    }

    /**
     * @param int $months
     * @return TermEntity
     * @throws \InvalidArgumentException
     */
    private function setMonths(int $months): TermEntity
    {
        if ($this->months > 0 === false) {
            throw new \InvalidArgumentException("Months can't be a zero value");
        }

        $this->months = $months;

        return $this;
    }

    /**
     * @return Identity
     */
    public function id(): Identity
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function months(): int
    {
        return $this->months;
    }

    /**
     * @return DateTime
     */
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return StatementContract
     */
    public function statement(): StatementContract
    {
        return $this->statement;
    }
}