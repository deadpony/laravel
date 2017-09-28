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
     * @return bool
     */
    public function create(array $input) : bool;

    /**
     * @param AccountContract $record
     * @param array $input
     * @return bool
     */
    public function update(AccountContract $record, array $input) : bool;

    /**
     * @param AccountContract $record
     * @return bool
     */
    public function delete(AccountContract $record) : bool;

}
