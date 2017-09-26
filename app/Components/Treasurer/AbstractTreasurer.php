<?php

namespace App\Components\Treasurer;

use App\Components\Treasurer\Contracts\TreasurerContract;

use App\Components\Treasurer\Miners\Contracts\MinerContract;
use Illuminate\Support\Collection;

/**
 * @method \App\Components\Treasurer\Miners\SalaryMiner salary()
 * @method \App\Components\Treasurer\Miners\VariousMiner various()
 */

abstract class AbstractTreasurer implements TreasurerContract {

    /**
     * @var Collection
     */
    protected $miners;

    public function __construct()
    {
        $this->miners = collect();
    }

    /**
     * @return Collection
     */
    public function miners(): Collection
    {
        if ($this->miners->isEmpty()) {
            // todo: init miners
        }

        return $this->miners;
    }

    /**
     * @param MinerContract $miner
     */
    private function setMiner($key, MinerContract $miner)
    {
        $this->miners->put($key, $miner);
    }

    public function __call($method, $parameters)
    {
        if (!$this->miners()->has($method)) {
            $miner = "\\App\\Components\\Treasurer\\Miners\\" .ucfirst($method) . "Miner";
            if (class_exists("{$miner}")) {

                $factory = app()->make($miner);

                if ($factory instanceof MinerContract) {
                    $this->setMiner($method, $factory);
                } else {
                    throw new \Exception('Not an instance of MinerContract');
                }

            } else {
                throw new \Exception('Not implemented');
            }
        }

        return $this->miners()->get($method);
    }
}