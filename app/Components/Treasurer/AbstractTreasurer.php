<?php

namespace App\Components\Treasurer;

use App\Components\Treasurer\Contracts\TreasurerContract;

use App\Components\Treasurer\Miners\Contracts\MinerContract;
use App\Components\Treasurer\Miners\SalaryMiner;
use App\Components\Treasurer\Miners\VariousMiner;
use Illuminate\Support\Collection;

/**
 * @method \App\Components\Treasurer\Miners\SalaryMiner salary()
 * @method \App\Components\Treasurer\Miners\VariousMiner various()
 */

abstract class AbstractTreasurer implements TreasurerContract {

    /**
     * @var Collection
     */
    protected $miners = [
        SalaryMiner::class,
        VariousMiner::class,
    ];

    public function __construct()
    {
        $this->miners = collect($this->miners)->flip()->map(function($node, $miner) {
            return app()->make($miner);
        });
    }

    /**
     * @return Collection
     */
    public function miners(): Collection
    {
        return $this->miners;
    }

    /**
     * @param MinerContract $miner
     */
    protected function setMiner(MinerContract $miner)
    {
        $this->miners->put(class_basename($miner), $miner);
    }

    /**
     * @param MinerContract $miner
     */
    protected function unsetMiner(MinerContract $miner)
    {
        $this->miners->forget(class_basename($miner));
    }

    public function __call($method, $parameters)
    {
        $miner = "App\\Components\\Treasurer\\Miners\\" .ucfirst($method) . "Miner";

        if (!$this->miners()->has($miner)) {
            throw new \Exception('Not implemented');
        }

        return $this->miners()->get($miner);
    }
}