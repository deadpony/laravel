<?php

namespace App\Components\Waster\Expenses\Repositories;

use App\Components\Waster\Expenses\Entities\Contracts\CoinContract;
use App\Components\Waster\Expenses\Repositories\Contracts\RepositoryContract;
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
    private $entity = CoinContract::class;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model  = $model;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $closure = call_user_func_array($name, $arguments);

        if (in_array($name, ['find', 'all', 'create', 'update', 'delete'])) {
            $this->model = $this->model->scratch();
        }

        return $closure;
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
        $result = $this->model->find($id);

        return $this->presentAsEntity($result->presentAsArray());
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        collect($filter)->each(function(array $params, string $field) {
            $this->model->where($field, array_get($params, 'operator', '='), array_get($params, 'value'));
        });

        return $this->model->getAll()->map(function(Model $item) {
            return $this->presentAsEntity($item->presentAsArray());
        });
    }

    /**
     * @param array $input
     * @return CoinContract
     */
    public function create(array $input): CoinContract
    {
        $item = $this->model->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @param array $input
     * @return CoinContract
     */
    public function update(int $id, array $input): CoinContract
    {
        $item = $this->model->find($id)->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->find($id)->performDelete();
    }

}