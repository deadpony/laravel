<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermDTO;
use App\Convention\DTO\Objects\Contracts\JsonDTO;

class AgreementDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var TermDTO|null
     */
    public $term;

    /**
     * @var array
     */
    public $payments;

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
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
            'term' => $this->term->toArray(),
            'payments' => $this->payments,
        ];
    }
}