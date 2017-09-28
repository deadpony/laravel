<?php

namespace App\Components\Treasurer\Miners;

use App\Components\Treasurer\Miners\Repositories\Contracts\CoinContract;
use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SalaryMiner extends AbstractMiner {

    /**
     * @var RepositoryContract
     */
    private $repository;

    /**
     * SalaryMiner constructor.
     * @param RepositoryContract $repository
     */
    public function __construct(RepositoryContract $repository)
    {
        $this->repository = $repository;

        $this->setType('salary');
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function earn(float $amount, Carbon $date = null): CoinContract
    {
        return $this->repository->create(
            [
                'type'       => $this->getType(),
                'amount'     => $amount,
                'created_at' => $date ?? Carbon::now(),
            ]
        );
    }

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function change(int $id, float $amount, Carbon $date = null): CoinContract
    {
        $coin = $this->repository->find($id);

        return $this->repository->update($coin, [
            'type'       => $this->getType(),
            'amount'     => $amount,
            'created_at' => $date ?? Carbon::now(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function refund(int $id): bool
    {
        $coin = $this->repository->find($id);

        return $this->repository->delete($coin);
    }

    /**
     * @return float
     */
    public function loot(): float
    {
        $loot = $this->repository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);

        return floatval($loot->sum(function(CoinContract $coin) {
            return $coin->getAmount();
        }));
    }

    /**
     * @return Collection
     */
    public function lootList(): Collection
    {
        return $this->repository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);
    }

}