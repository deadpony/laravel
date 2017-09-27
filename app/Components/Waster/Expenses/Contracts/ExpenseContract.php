<?php

namespace App\Components\Waster\Expenses\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ExpenseContract {

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function charge(float $amount, Carbon $date = null) : bool;

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
    public function claim(int $id) : bool;

    /**
     * @return float
     */
    public function costs() : float;

    /**
     * @return Collection
     */
    public function costsList() : Collection;

}