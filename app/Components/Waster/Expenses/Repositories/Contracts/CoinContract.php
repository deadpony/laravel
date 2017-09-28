<?php

namespace App\Components\Waster\Expenses\Repositories\Contracts;

use Illuminate\Support\Collection;

interface CoinContract {

    /**
     * @return self
     */
    public function scratch() : self;

    /**
     * @param array $input
     * @return CoinContract
     */
    public function fill(array $input) : self;

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return self
     */
    public function find(int $id) : self;

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
