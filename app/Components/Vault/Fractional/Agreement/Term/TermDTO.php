<?php

namespace App\Components\Vault\Fractional\Agreement\Term;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Convention\DTO\Objects\Contracts\JsonDTO;

class TermDTO implements JsonDTO
{
    /**
     * @var string
     */
    public $id;

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
            'months' => $this->months,
            'deadlineDay' => $this->deadlineDay,
            'setupFee' => $this->setupFee,
            'monthlyFee' => $this->monthlyFee,
            'createdAt' => $this->createdAt,
        ];
    }
}