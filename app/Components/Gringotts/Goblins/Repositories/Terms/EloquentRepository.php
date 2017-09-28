<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms;

use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\RepositoryContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\TermContract;
use Illuminate\Support\Collection;

class EloquentRepository implements RepositoryContract 
{

    /**
     * @var TermContract
     */
    private $term;

    /**
     * EloquentRepository constructor.
     * @param TermContract $coin
     */
    public function __construct(TermContract $coin)
    {
        $this->term = $coin;
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        return $this->term->getAll($filter);
    }

    /**
     * @param int $id
     * @return TermContract
     */
    public function find(int $id): TermContract
    {
        return $this->term->find($id);
    }

    /**
     * @param array $input
     * @return TermContract
     */
    public function create(array $input): TermContract
    {
        return $this->term->scratch()->fill($input)->performSave();
    }

    /**
     * @param TermContract $record
     * @param array $input
     * @return TermContract
     */
    public function update(TermContract $record, array $input): TermContract
    {
        $this->term = $record;
        
        return $this->term->fill($input)->performSave();
    }

    /**
     * @param TermContract $record
     * @return bool
     */
    public function delete(TermContract $record): bool
    {
        $this->term = $record;

        return (bool) $this->term->performDelete();
    }

}