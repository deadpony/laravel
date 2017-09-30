<?php

namespace App\Components\Gringotts\Contracts;

use Illuminate\Support\Collection;

interface GringottsContract {

    /**
     * @return Collection
     */
    public function goblins() : Collection;

    /**
     * @return float
     */
    public function debt() : float;

    /**
     * @return Collection
     */
    public function debtList() : Collection;

}