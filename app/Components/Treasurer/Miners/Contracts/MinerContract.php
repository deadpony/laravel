<?php

namespace App\Components\Treasurer\Miners\Contracts;

interface MinerContract {

    /**
     * @param float $amount
     * @return bool
     */
    public function earn(float $amount) : bool;

    /**
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function change(int $id, float $amount) : bool;

    /**
     * @param int $id
     * @return bool
     */
    public function refund(int $id) : bool;

}