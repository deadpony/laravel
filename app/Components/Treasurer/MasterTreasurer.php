<?php

namespace App\Components\Treasurer;

use App\Components\Treasurer\Miners\Contracts\MinerContract;
use Illuminate\Support\Collection;

class MasterTreasurer extends AbstractTreasurer {

    /**
     * @return float
     */
    public function loot(): float
    {
        return $this->miners()->sum(function(MinerContract $miner) {
            return $miner->loot();
        });
    }

    /**
     * @return Collection
     */
    public function lootList(): Collection
    {
        return $this->miners()->flatMap(function(MinerContract $miner) {
            return $miner->lootList();
        });
    }

}