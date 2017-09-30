<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms\Contracts;

use App\Components\Gringotts\Goblins\Entities\Contracts\TermContract;
use Illuminate\Support\Collection;

interface RepositoryContract {

    /**
     * @param int $id
     * @return TermContract
     * @throws \Exception if not found
     */
    public function find(int $id) : TermContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []) : Collection;

    /**
     * @param array $input
     * @return TermContract
     */
    public function create(array $input) : TermContract;

    /**
     * @param int $id
     * @param array $input
     * @return TermContract
     */
    public function update(int $id, array $input) : TermContract;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

}
