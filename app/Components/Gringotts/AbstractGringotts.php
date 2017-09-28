<?php

namespace App\Components\Gringotts;

use App\Components\Gringotts\Goblins\Contracts\GoblinContract;
use App\Components\Gringotts\Goblins\CreditGoblin;
use App\Components\Gringotts\Goblins\InstallmentGoblin;
use Illuminate\Support\Collection;

/**
 * @method \App\Components\Gringotts\Goblins\CreditGoblin credit()
 * @method \App\Components\Gringotts\Goblins\InstallmentGoblin installment()
 */

abstract class AbstractGringotts implements GringottsContract
{
    /**
     * @var Collection
     */
    protected $goblins = [
        CreditGoblin::class,
        InstallmentGoblin::class,
    ];

    public function __construct()
    {
        $this->goblins = collect($this->goblins)->flip()->map(function($node, $goblin) {
            return app()->make($goblin);
        });
    }

    /**
     * @return Collection
     */
    public function goblins(): Collection
    {
        return $this->goblins;
    }

    /**
     * @param GoblinContract $goblin
     */
    protected function setGoblin(GoblinContract $goblin)
    {
        $this->goblins->put(class_basename($goblin), $goblin);
    }

    /**
     * @param GoblinContract $goblin
     */
    protected function unsetGoblin(GoblinContract $goblin)
    {
        $this->goblins->forget(class_basename($goblin));
    }

    public function __call($method, $parameters)
    {
        $goblin = "App\\Components\\Gringotts\\Goblins\\" .ucfirst($method) . "Goblin";

        if (!$this->miners()->has($goblin)) {
            throw new \Exception('Not implemented');
        }

        return $this->miners()->get($goblin);
    }
}