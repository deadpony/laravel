<?php

namespace App\Components\Waster;

use App\Components\Waster\Expenses\Contracts\ExpenseContract;
use Illuminate\Support\Collection;

class MasterWaster extends AbstractWaster {

    /**
     * @return float
     */
    public function costs(): float
    {
        return $this->expenses()->sum(function(ExpenseContract $expense) {
            return $expense->costs();
        });
    }

    /**
     * @return Collection
     */
    public function costsList(): Collection
    {
        return $this->expenses()->flatMap(function(ExpenseContract $expense) {
            return $expense->costsList();
        });
    }

}