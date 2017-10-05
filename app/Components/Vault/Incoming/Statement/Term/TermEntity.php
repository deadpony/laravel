<?php

namespace App\Components\Vault\Incoming\Statement\Term;

use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Convention\ValueObjects\DateTime\DateTime;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="incoming_statements_terms")
 */
class TermEntity implements TermContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\Column(type="string",unique=true)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="integer",nullable=false)
     */
    private $months;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime",nullable=false,name="created_at")
     */
    private $createdAt;

    /**
     * @var StatementContract
     * @ORM\OneToOne(targetEntity="App\Components\Vault\Incoming\Statement\StatementEntity", inversedBy="term", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="statement_id", referencedColumnName="id")
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

        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param int $months
     * @return TermEntity
     * @throws \InvalidArgumentException
     */
    private function setMonths(int $months): TermEntity
    {
        if ($months > 0 === false) {
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

    /**
     * @param int $months
     * @return TermContract
     */
    public function updateMonths(int $months): TermContract
    {
        $this->setMonths($months);

        return $this;
    }
}