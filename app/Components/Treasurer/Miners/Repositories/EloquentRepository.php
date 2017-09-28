<?php

namespace App\Components\Treasurer\Miners\Repositories;

use App\Components\Treasurer\Miners\Repositories\Contracts\CoinContract;
use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use Illuminate\Support\Collection;

class EloquentRepository implements RepositoryContract {

    /**
     * @var CoinContract
     */
    private $coin;

    /**
     * EloquentRepository constructor.
     * @param CoinContract $coin
     */
    public function __construct(CoinContract $coin)
    {
        $this->coin = $coin;
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        return $this->coin->getAll($filter);
    }

    /**
     * @param int $id
     * @return CoinContract
     */
    public function find(int $id): CoinContract
    {
        return $this->coin->find($id);
    }

    /**
     * @param array $input
     * @return CoinContract
     */
    public function create(array $input): CoinContract
    {
        return $this->coin->scratch()->fill($input)->performSave();
    }

    /**
     * @param CoinContract $record
     * @param array $input
     * @return CoinContract
     */
    public function update(CoinContract $record, array $input): CoinContract
    {
        $this->coin = $record;
        
        return $this->coin->fill($input)->performSave();
    }

    /**
     * @param CoinContract $record
     * @return bool
     */
    public function delete(CoinContract $record): bool
    {
        $this->coin = $record;

        return (bool) $this->coin->performDelete();
    }

}