<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts;

use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract;
use Illuminate\Support\Collection;

class EloquentRepository implements RepositoryContract {

    /**
     * @var AccountContract
     */
    private $account;

    /**
     * EloquentRepository constructor.
     * @param AccountContract $coin
     */
    public function __construct(AccountContract $coin)
    {
        $this->account = $coin;
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        return $this->account->getAll($filter);
    }

    /**
     * @param int $id
     * @return AccountContract
     */
    public function find(int $id): AccountContract
    {
        return $this->account->find($id);
    }

    /**
     * @param array $input
     * @return AccountContract
     */
    public function create(array $input): AccountContract
    {
        return $this->account->scratch()->fill($input)->performSave();
    }

    /**
     * @param AccountContract $record
     * @param array $input
     * @return AccountContract
     */
    public function update(AccountContract $record, array $input): AccountContract
    {
        $this->account = $record;
        
        return $this->account->fill($input)->performSave();
    }

    /**
     * @param AccountContract $record
     * @return bool
     */
    public function delete(AccountContract $record): bool
    {
        $this->account = $record;

        return (bool) $this->account->performDelete();
    }

}