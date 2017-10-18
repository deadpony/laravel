<?php

namespace App\Components\Vault\Fractional\Agreement\Term;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Convention\DTO\Contracts\JsonDTO;

class TermDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $identity;

    /**
     * @var int
     */
    public $months;

    /**
     * @var int
     */
    public $deadlineDay;

    /**
     * @var float
     */
    public $setupFee;

    /**
     * @var float
     */
    public $monthlyFee;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var AgreementDTO
     */
    public $agreement;

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
            'months' => $this->months,
            'deadlineDay' => $this->deadlineDay,
            'setupFee' => $this->setupFee,
            'monthlyFee' => $this->monthlyFee,
            'createdAt' => $this->createdAt,
        ];
    }
}