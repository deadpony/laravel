<?php

namespace App\Components\Vault\Incoming\Statement;

use App\Components\Vault\Incoming\Statement\Term\TermContract;
use App\Convention\ValueObjects\DateTime\DateTime;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="statements")
 */
class StatementEntity implements StatementContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="none")
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable="false", column="created_at")
     */
    private $createdAt;

    /**
     * @var TermContract|null;
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

        $this->createdAt = new DateTime(new \DateTimeImmutable());
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
        if ($this->amount > 0 === false) {
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
     * @return DateTime
     */
    public function createdAt(): DateTime
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

}