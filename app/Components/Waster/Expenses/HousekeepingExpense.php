<?php

namespace App\Components\Waster\Expenses;

use App\Components\Waster\Expenses\Repositories\Contracts\CoinContract;
use App\Components\Waster\Expenses\Repositories\Contracts\RepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HousekeepingExpense extends AbstractExpense {

    /**
     * @var RepositoryContract
     */
    private $repository;

    /**
     * HousekeepingExpense constructor.
     * @param RepositoryContract $repository
     */
    public function __construct(RepositoryContract $repository)
    {
        $this->repository = $repository;

        $this->setType('housekeeping');
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function charge(float $amount, Carbon $date = null): bool
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
     * @return bool
     */
    public function change(int $id, float $amount, Carbon $date = null): bool
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
    public function claim(int $id): bool
    {
        $coin = $this->repository->find($id);

        return $this->repository->delete($coin);
    }

    /**
     * @return float
     */
    public function costs(): float
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
    public function costsList(): Collection
    {
        return $this->repository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);
    }

}