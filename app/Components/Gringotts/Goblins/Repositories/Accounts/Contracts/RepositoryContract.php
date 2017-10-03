<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Entities\Account\Term\Contracts\TermContract;
use Illuminate\Support\Collection;

interface RepositoryContract
{

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function find(int $id): AccountContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection;

    /**
     * @param array $input
     * @return AccountContract
     */
    public function create(array $input): AccountContract;

    /**
     * @param int $id
     * @param array $input
     * @return AccountContract
     */
    public function update(int $id, array $input): AccountContract;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param AccountContract $account
     * @param array $input
     * @return AccountContract
     */
    public function createTerm(AccountContract $account, array $input): AccountContract;

    /**
     * @param TermContract    $term
     * @param array $input
     * @return AccountContract
     */
    public function updateTerm(TermContract $term, array $input): AccountContract;

    /**
     * @param TermContract    $term
     * @return bool
     */
    public function deleteTerm(TermContract $term): bool;
}
