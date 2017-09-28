<?php

namespace App\Components\Treasurer\Miners\Repositories\Contracts;

use Illuminate\Support\Collection;

interface CoinContract {

    /**
     * @return CoinContract
     */
    public function scratch() : CoinContract;

    /**
     * @param array $input
     * @return CoinContract
     */
    public function fill(array $input) : CoinContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return CoinContract
     */
    public function find(int $id) : CoinContract;

    /**
     * @return CoinContract
     */
    public function performSave() : CoinContract;

    /**
     * @return bool
     */
    public function performDelete() : bool;

    /**
     * @return array
     */
    public function presentAsArray() : array;

    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @return float
     */
    public function getAmount() : float;
}
