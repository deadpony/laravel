<?php

namespace App\Components\Waster\Contracts;

use Illuminate\Support\Collection;

interface WasterContract {

    /**
     * @return Collection
     */
    public function expenses() : Collection;

    /**
     * @return float
     */
    public function costs() : float;

    /**
     * @return Collection
     */
    public function costsList() : Collection;

}