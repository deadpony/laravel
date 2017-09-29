<?php

namespace App\Helpers\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \App\Helpers\Models\Contracts\Model as ModelContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class Eloquent extends Model implements ModelContract
{
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
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []): Collection
    {
        if ($filter) {
            $query = self::newQuery();

            collect($filter)->each(function ($condition, $field) use ($query) {
                if (array_get($condition, 'value')) {
                    $query->{array_get($condition, 'function', 'where')}($field,
                        array_get($condition, 'condition', '='), array_get($condition, 'value'));
                } else {
                    // todo: log this
                }
            });

            return $query->get();
        }

        return self::all();
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
            $item = $this->newQuery()->findOrFail($id);
            return $item;
        } catch (ModelNotFoundException $ex) {
            throw new \Exception("Not exists with given id: {$id}");
        }
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