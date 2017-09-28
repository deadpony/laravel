<?php

namespace App\Components\Gringotts;

use App\Components\Gringotts\Goblins\Contracts\GoblinContract;
use Illuminate\Support\Collection;

class MasterGringotts extends AbstractGringotts
{
    /**
     * @return float
     */
    public function debt(): float
    {
        return $this->goblins()->sum(function(GoblinContract $goblin) {
            return $goblin->debt();
        });
    }

    /**
     * @return Collection
     */
    public function debtList(): Collection
    {
        return $this->goblins()->flatMap(function(GoblinContract $goblin) {
            return $goblin->debtList();
        });
    }

}