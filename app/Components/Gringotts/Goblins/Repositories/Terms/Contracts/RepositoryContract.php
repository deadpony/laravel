<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms\Contracts;

use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return TermContract
     */
    public function find(int $id) : TermContract;

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input) : bool;

    /**
     * @param TermContract $record
     * @param array $input
     * @return bool
     */
    public function update(TermContract $record, array $input) : bool;

    /**
     * @param TermContract $record
     * @return bool
     */
    public function delete(TermContract $record) : bool;

}
