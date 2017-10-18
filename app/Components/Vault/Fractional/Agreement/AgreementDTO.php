<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Term\TermDTO;
use App\Convention\DTO\Contracts\JsonDTO;

class AgreementDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $identity;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var TermDTO
     */
    public $term;

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
            'amount' => $this->amount,
            'createdAt' => $this->createdAt,
            'term' => $this->term->toArray(),
        ];
    }
}