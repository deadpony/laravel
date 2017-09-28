<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

use Illuminate\Support\Collection;

interface AccountContract {

    /**
     * @return AccountContract
     */
    public function scratch() : AccountContract;

    /**
     * @param array $input
     * @return AccountContract
     */
    public function fill(array $input) : AccountContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return AccountContract
     */
    public function find(int $id) : AccountContract;

    /**
     * @return AccountContract
     */
    public function performSave() : AccountContract;

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
