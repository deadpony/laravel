<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return AccountContract
     */
    public function find(int $id) : AccountContract;

    /**
     * @param array $input
     * @return AccountContract
     */
    public function create(array $input) : AccountContract;

    /**
     * @param AccountContract $record
     * @param array $input
     * @return AccountContract
     */
    public function update(AccountContract $record, array $input) : AccountContract;

    /**
     * @param AccountContract $record
     * @return bool
     */
    public function delete(AccountContract $record) : bool;

}
