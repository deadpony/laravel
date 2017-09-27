<?php

namespace App\Components\Waster\Expenses\Repositories\Contracts;

use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return CoinContract
     */
    public function find(int $id) : CoinContract;

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input) : bool;

    /**
     * @param CoinContract $record
     * @param array $input
     * @return bool
     */
    public function update(CoinContract $record, array $input) : bool;

    /**
     * @param CoinContract $record
     * @return bool
     */
    public function delete(CoinContract $record) : bool;

}
