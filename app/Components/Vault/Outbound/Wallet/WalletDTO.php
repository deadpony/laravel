<?php

namespace App\Components\Vault\Outbound\Wallet;

use App\Convention\DTO\Objects\Contracts\JsonDTO;

class WalletDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $id;

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
        return $this->id;
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
            'id' => $this->id,
            'type' => $this->type,
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
        ];
    }
}