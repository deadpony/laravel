<?php

namespace App\Components\Vault\Installment\Statement;

use App\Components\Vault\Installment\Statement\Term\TermContract;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="installment_statements")
 */
class StatementEntity implements StatementContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\Column(type="identity",unique=true)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=false)
     */
    private $type;

    /**
     * @var float
     * @ORM\Column(type="float",nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false,name="created_at")
     */
    private $createdAt;

    /**
     * @var TermContract|null;
     * @ORM\OneToOne(targetEntity="App\Components\Vault\Installment\Statement\Term\TermEntity", mappedBy="statement", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     */
    private $term;

    /**
     * @param Identity $id
     * @param string $type
     * @param float $amount
     * @param TermContract|null $term
     */
    public function __construct(Identity $id, string $type, float $amount, TermContract $term = null)
    {
        $this->id = $id;
        $this->setType($type);
        $this->setAmount($amount);

        $this->term = $term;

        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param string $type
     * @return StatementEntity
     */
    private function setType(string $type): StatementEntity
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param float $amount
     * @return StatementEntity
     * @throws \InvalidArgumentException
     */
    private function setAmount(float $amount): StatementEntity
    {
        if ($amount > 0 === false) {
            throw new \InvalidArgumentException("Amount can't be a zero value");
        }

        $this->amount = $amount;

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
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return TermContract|null
     */
    public function term()
    {
        return $this->term;
    }

    /**
     * @param TermContract $term
     * @return StatementContract
     */
    public function assignTerm(TermContract $term): StatementContract
    {
        if ($this->term() instanceof TermContract) {
            throw new \InvalidArgumentException("Term already assigned");
        }

        $this->term = $term;

        return $this;
    }

    /**
     * @param float $amount
     * @return StatementContract
     */
    public function updateAmount(float $amount): StatementContract
    {
        $this->setAmount($amount);

        return $this;
    }
}