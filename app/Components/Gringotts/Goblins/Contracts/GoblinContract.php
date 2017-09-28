<?php

namespace App\Components\Gringotts\Goblins\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface GoblinContract {

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function open(float $amount, Carbon $date = null) : bool;

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function change(int $id, float $amount, Carbon $date = null) : bool;

    /**
     * @param int $id
     * @return bool
     */
    public function close(int $id) : bool;

    /**
     * @return float
     */
    public function debt() : float;

    /**
     * @return Collection
     */
    public function debtList() : Collection;

}