<?php

namespace App\Components\Gringotts\Goblins\Contracts;

use App\Components\Gringotts\Goblins\Entities\Contracts\AccountContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface GoblinContract
{

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function view(int $id): AccountContract;

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function open(float $amount, Carbon $date = null): AccountContract;

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function change(int $id, float $amount, Carbon $date = null): AccountContract;

    /**
     * @param int $id
     * @return bool
     */
    public function close(int $id): bool;

    /**
     * @return float
     */
    public function debt(): float;

    /**
     * @return Collection
     */
    public function debtList(): Collection;

}