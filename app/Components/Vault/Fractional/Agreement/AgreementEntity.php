<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Outbound\Wallet\WalletContract;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var ArrayCollection;
     * @ORM\ManyToMany(targetEntity="App\Components\Vault\Outbound\Wallet\WalletEntity", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="fractional_agreements_outbound_wallet",
     *      joinColumns={@ORM\JoinColumn(name="fractional_agreement_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="outbound_wallet_id", referencedColumnName="id", unique=true)})
     */
    private $payments;

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

        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();

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
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
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
     * @return array
     */
    public function payments(): array
    {
        return $this->payments->toArray();
    }

    /**
     * @param WalletContract $payment
     * @return bool
     */
    public function pay(WalletContract $payment): bool
    {
        if (!$this->payments->contains($payment))
            $this->payments->add($payment);

        return true;
    }

    /**
     * @param WalletContract $payment
     * @return bool
     */
    public function refund(WalletContract $payment): bool
    {
        $this->payments->removeElement($payment);

        return true;
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

    /**
     * @return bool
     */
    public function isDeadlineReached(): bool
    {
        // TODO: Implement isDeadlineReached() method.
    }

    /**
     * @return bool
     */
    public function isDeadlinePassed(): bool
    {
        // TODO: Implement isDeadlinePassed() method.
    }

    /**
     * @return bool
     */
    public function isAgreementPassed(): bool
    {
        // TODO: Implement isAgreementPassed() method.
    }


}