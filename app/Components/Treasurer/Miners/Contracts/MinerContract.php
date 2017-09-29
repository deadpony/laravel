<?php

namespace App\Components\Treasurer\Miners\Contracts;

use App\Components\Treasurer\Miners\Entities\Contracts\CoinContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface MinerContract {

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function earn(float $amount, Carbon $date = null) : CoinContract;

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
    public function refund(int $id) : bool;

    /**
     * @return float
     */
    public function loot() : float;

    /**
     * @return Collection
     */
    public function lootList() : Collection;

}