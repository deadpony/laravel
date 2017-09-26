<?php

namespace App\Components\Treasurer\Miners\Repositories\Contracts;

use Illuminate\Support\Collection;

interface CoinContract {

    /**
     * @return self
     */
    public function scratch() : self;

    /**
     * @param array $input
     * @return CoinContract
     */
    public function fill(array $input) : self ;

    /**
     * @return Collection
     */
    public function getAll() : Collection;

    /**
     * @param int $id
     * @return self
     */
    public function find(int $id) : self;

    /**
     * @return bool
     */
    public function performSave() : bool;

    /**
     * @return bool
     */
    public function performDelete() : bool;

    /**
     * @return array
     */
    public function presentAsArray() : array;
}
