<?php

namespace App\Components\Treasurer\Miners\Repositories\Contracts;

use App\Components\Treasurer\Miners\Entities\Contracts\CoinContract;
use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param int $id
     * @return CoinContract
     */
    public function find(int $id) : CoinContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param array $input
     * @return CoinContract
     */
    public function create(array $input) : CoinContract;

    /**
     * @param int $id
     * @param array $input
     * @return CoinContract
     */
    public function update(int $id, array $input) : CoinContract;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

}
