<?php

namespace App\Components\Gringotts\Goblins\Entities\Contracts;

use App\Helpers\Entities\Contracts\Composable;
use Carbon\Carbon;

interface AccountContract extends Composable
{

    /**
     * @return int
     */
    public function getID(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setID(int $id): void;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @param float $amount
     * @return void
     */
    public function setAmount(float $amount): void;

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon;

    /**
     * @param Carbon $createdAt
     * @return void
     */
    public function setCreatedAt(Carbon $createdAt): void;
}
