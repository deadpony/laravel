<?php

namespace App\Components\Treasurer\Contracts;

use Illuminate\Support\Collection;

interface TreasurerContract {

    /**
     * @return Collection
     */
    public function miners() : Collection;

    /**
     * @return float
     */
    public function loot() : float;

    /**
     * @return Collection
     */
    public function lootList() : Collection;

}