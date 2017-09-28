<?php

namespace App\Components\Waster\Expenses\Contracts;

use App\Components\Waster\Expenses\Repositories\Contracts\CoinContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ExpenseContract {

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function charge(float $amount, Carbon $date = null) : CoinContract;

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function change(int $id, float $amount, Carbon $date = null) : CoinContract;

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