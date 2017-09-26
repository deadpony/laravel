<?php

namespace App\Components\Treasurer\Miners\Contracts;

use Carbon\Carbon;

interface MinerContract {

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function earn(float $amount, Carbon $date = null) : bool;

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
    public function refund(int $id) : bool;

}