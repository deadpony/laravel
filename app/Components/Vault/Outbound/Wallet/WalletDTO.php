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
     * @return string
     */
    public function __toJson(): string
    {
        return json_encode($this->__toArray());
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'identity' => $this->identity,
            'type' => $this->type,
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
        ];
    }
}