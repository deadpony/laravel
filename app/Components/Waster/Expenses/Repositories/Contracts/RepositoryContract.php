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
     * @return CoinContract
     */
    public function create(array $input) : CoinContract;

    /**
     * @param CoinContract $record
     * @param array $input
     * @return CoinContract
     */
    public function update(CoinContract $record, array $input) : CoinContract;

    /**
     * @param CoinContract $record
     * @return bool
     */
    public function delete(CoinContract $record) : bool;

}
