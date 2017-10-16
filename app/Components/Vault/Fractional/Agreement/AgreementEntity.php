<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fractional_agreements")
 */
class AgreementEntity implements AgreementContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\Column(type="identity",unique=true)
     */
    private $id;

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
     * @ORM\OneToOne(targetEntity="App\Components\Vault\Fractional\Agreement\Term\TermEntity", mappedBy="agreement", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     */
    private $term;

    /**
     * @param Identity $id
     * @param float $amount
     * @param TermContract|null $term
     */
    public function __construct(Identity $id, float $amount, TermContract $term = null)
    {
        $this->id = $id;
        $this->setAmount($amount);

        $this->term = $term;

        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param float $amount
     * @return AgreementEntity
     * @throws \InvalidArgumentException
     */
    private function setAmount(float $amount): AgreementEntity
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
     * @return AgreementContract
     */
    public function assignTerm(TermContract $term): AgreementContract
    {
        if ($this->term() instanceof TermContract) {
            throw new \InvalidArgumentException("Term already assigned");
        }

        $this->term = $term;

        return $this;
    }

    /**
     * @param float $amount
     * @return AgreementContract
     */
    public function updateAmount(float $amount): AgreementContract
    {
        $this->setAmount($amount);

        return $this;
    }
}