<?php

namespace App\Helpers\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use \App\Helpers\Models\Contracts\Model as ModelContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class Eloquent extends Model implements ModelContract
{
    /**
     * @var Builder
     */
    private $builder;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->builder  = $this->newQuery();
    }

    /**
     * @return ModelContract
     */
    public function scratch(): ModelContract
    {
        return $this->newInstance();
    }

    /**
     * @param array $input
     * @return ModelContract
     */
    public function fill(array $input): ModelContract
    {
        parent::fill($input);

        return $this;
    }

    /**
     * @return ModelContract
     * @throws \Exception if not found
     */
    public function getOne(): ModelContract
    {
        try {
            /** @var ModelContract $item */
            $item =  $this->builder->firstOrFail();
            return $item;
        } catch (ModelNotFoundException $ex) {
            throw new \Exception("Not exists");
        }
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->builder->get();
    }

    /**
     * @param int $id
     * @return ModelContract
     * @throws \Exception if not found
     */
    public function find(int $id): ModelContract
    {
        try {
            /** @var ModelContract $item */
            $item = $this->builder->findOrFail($id);
            return $item;
        } catch (ModelNotFoundException $ex) {
            throw new \Exception("Not exists with given id: {$id}");
        }
    }

    /**
     * @param string $field
     * @param string $operator
     * @param $value
     * @return ModelContract
     */
    public function where(string $field, string $operator, $value): ModelContract
    {
        $this->builder->where($field, $operator, $value);

        return $this;
    }

    /**
     * @return ModelContract
     * @throws \Exception if couldn't save
     */
    public function performSave(): ModelContract
    {
        if ($this->save()) {
            return $this;
        }

        throw new \Exception("Couldn't save");
    }

    /**
     * @return bool
     */
    public function performDelete(): bool
    {
        return $this->delete();
    }

    /**
     * @return array
     */
    public function presentAsArray(): array
    {
        return collect($this->toArray())->map(function ($value, $key) {
            if (in_array($key, $this->dates)) {
                return Carbon::parse($value);
            }

            return $value;
        })->toArray();
    }
}