<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms;

use App\Components\Gringotts\Goblins\Entities\Contracts\TermContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\RepositoryContract;
use App\Helpers\Entities\Composable;
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
    private $entity = TermContract::class;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model  = $model;
    }

    /**
     * @param array $input
     * @return TermContract
     * @throws \Exception
     */
    private function presentAsEntity(array $input): TermContract
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
     * @return TermContract
     * @throws \Exception if not found
     */
    public function find(int $id): TermContract
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
     * @return TermContract
     */
    public function create(array $input): TermContract
    {
        $item = $this->model->scratch()->fill($input)->performSave();

        return $this->presentAsEntity($item->presentAsArray());
    }

    /**
     * @param int $id
     * @param array $input
     * @return TermContract
     */
    public function update(int $id, array $input): TermContract
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