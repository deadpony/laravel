<?php

namespace App\Components\Waster\Expenses;

use App\Components\Waster\Expenses\Contracts\ExpenseContract;

abstract class AbstractExpense implements ExpenseContract {

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type) : void
    {
        $this->type = $type;
    }

}