<?php

namespace App\Components\Vault\Outbound\Wallet;

use App\Convention\DTO\Contracts\JsonDTO;

class WalletDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $identity;

    /**
     * @var string
     */
    public $type;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->identity;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'identity' => $this->identity,
            'type' => $this->type,
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
        ];
    }
}