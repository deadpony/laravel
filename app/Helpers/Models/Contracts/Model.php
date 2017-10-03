<?php

namespace App\Helpers\Models\Contracts;

use Illuminate\Support\Collection;

interface Model
{
    /**
     * @return Model
     */
    public function scratch(): Model;

    /**
     * @param array $input
     * @return Model
     */
    public function fill(array $input): Model;

    /**
     * @return Model
     * @throws \Exception if not found
     */
    public function getOne(): Model;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param int $id
     * @return Model
     * @throws \Exception if not found
     */
    public function find(int $id): Model;

    /**
     * @param string $field
     * @param string $operator
     * @param $value
     * @return Model
     */
    public function where(string $field, string $operator, $value): Model;

    /**
     * @return Model
     * @throws \Exception if couldn't save
     */
    public function performSave(): Model;

    /**
     * @return bool
     */
    public function performDelete(): bool;

    /**
     * @return array
     */
    public function presentAsArray(): array;
}
