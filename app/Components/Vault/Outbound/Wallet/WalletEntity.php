<?php

namespace App\Components\Vault\Outbound\Wallet;

use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="outbound_wallet")
 */
class WalletEntity implements WalletContract
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
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime",nullable=false,name="created_at")
     */
    private $createdAt;

    /**
     * @param Identity $id
     * @param string $type
     * @param float $amount
     */
    public function __construct(Identity $id, string $type, float $amount)
    {
        $this->id = $id;
        $this->setType($type);
        $this->setAmount($amount);

        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param string $type
     * @return WalletEntity
     */
    private function setType(string $type): WalletEntity
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param float $amount
     * @return WalletEntity
     * @throws \InvalidArgumentException
     */
    private function setAmount(float $amount): WalletEntity
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
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param float $amount
     * @return WalletContract
     */
    public function updateAmount(float $amount): WalletContract
    {
        $this->setAmount($amount);

        return $this;
    }
}