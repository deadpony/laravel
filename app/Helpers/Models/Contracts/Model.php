<?php

namespace App\Helpers\Models\Contracts;

use Illuminate\Support\Collection;

interface Model
{
    /**
     * @return Model
     */
    public function scratch() : Model;

    /**
     * @param array $input
     * @return Model
     */
    public function fill(array $input) : Model;

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return Model
     * @throws \Exception if not found
     */
    public function find(int $id) : Model;

    /**
     * @return Model
     * @throws \Exception if couldn't save
     */
    public function performSave() : Model;

    /**
     * @return bool
     */
    public function performDelete() : bool;

    /**
     * @return array
     */
    public function presentAsArray() : array;
}
