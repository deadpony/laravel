<?php

namespace App\Components\Waster;

use App\Components\Waster\Contracts\WasterContract;
use App\Components\Waster\Expenses\ApplianceExpense;
use App\Components\Waster\Expenses\Contracts\ExpenseContract;
use App\Components\Waster\Expenses\FoodExpense;
use Illuminate\Support\Collection;

/**
 * @method \App\Components\Waster\Expenses\FoodExpense food()
 * @method \App\Components\Waster\Expenses\ApplianceExpense appliance()
 * @method \App\Components\Waster\Expenses\HousekeepingExpense housekeeping()
 * @method \App\Components\Waster\Expenses\FunExpense fun()
 * @method \App\Components\Waster\Expenses\WearableExpense wearable()
 */

abstract class AbstractWaster implements WasterContract {

    /**
     * @var Collection
     */
    protected $expenses = [
        FoodExpense::class,
        ApplianceExpense::class,
    ];

    public function __construct()
    {
        $this->expenses = collect($this->expenses)->flip()->map(function($node, $expense) {
            return app()->make($expense);
        });
    }

    /**
     * @return Collection
     */
    public function expenses(): Collection
    {
        return $this->expenses;
    }

    /**
     * @param ExpenseContract $expense
     */
    protected function setExpense(ExpenseContract $expense)
    {
        $this->expenses->put(class_basename($expense), $expense);
    }

    /**
     * @param ExpenseContract $expense
     */
    protected function unsetExpense(ExpenseContract $expense)
    {
        $this->expenses->forget(class_basename($expense));
    }

    public function __call($method, $parameters)
    {
        $expense = "App\\Components\\Waster\\Expenses\\" .ucfirst($method) . "Expense";

        if (!$this->expenses()->has($expense)) {
            throw new \Exception('Not implemented');
        }

        return $this->expenses()->get($expense);
    }
}