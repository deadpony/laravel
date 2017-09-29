<?php

namespace App\Components\Treasurer\Miners\Repositories;

use App\Components\Treasurer\Miners\Entities\Contracts\CoinContract;
use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use App\Helpers\Entities\Contracts\Composable;
use App\Helpers\Models\Contracts\Model;
use Illuminate\Support\Collection;

class EloquentRepository implements RepositoryContract
{

    /**
     * @var Model
     */
    private $model;

    /**
     * @var string
     */
    private $entity = "App\\Components\\Treasurer\\Miners\\Entities\\CoinEntity";

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model  = $model;
    }

    /**
     * @param array $input
     * @return CoinContract
     * @throws \Exception
     */
    private function presentAsEntity(array $input): CoinContract
    {
        $entity = app()->make($this->entity);

        if (!$entity instanceof Composable) {
            throw new \Exception("Entity should be an instance of Composable");
        }

        $entity->compose($input);

        return $entity;
    }

    /**
     * @param int $id
     * @return CoinContract
     * @throws \Exception if not found
     */
    public function find(int $id): CoinContract
    {
        $result = $this->model->scratch()->find($id);

        return $this->presentAsEntity($result->presentAsArray());
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        return $this->model->scratch()->getAll($filter)->map(function(Model $item) {
            return $this->presentAsEntity($item->presentAsArray());
        });
    }

    /**
     * @param array $input
     * @return CoinContract
     */
    public function create(array $input): CoinContract
    {
        $item = $this->model->scratch()->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @param array $input
     * @return CoinContract
     */
    public function update(int $id, array $input): CoinContract
    {
        $item = $this->model->scratch()->find($id)->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->scratch()->find($id)->performDelete();
    }

}