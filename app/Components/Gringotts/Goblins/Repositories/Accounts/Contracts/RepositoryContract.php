<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

use App\Components\Gringotts\Goblins\Entities\Contracts\AccountContract;
use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function find(int $id) : AccountContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param array $input
     * @return AccountContract
     */
    public function create(array $input) : AccountContract;

    /**
     * @param int $id
     * @param array $input
     * @return AccountContract
     */
    public function update(int $id, array $input) : AccountContract;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

}
