<?php

namespace App\Components\Waster\Expenses;

use App\Components\Waster\Expenses\Entities\Contracts\CoinContract;
use App\Components\Waster\Expenses\Repositories\Contracts\RepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FunExpense extends AbstractExpense {

    /**
     * @var RepositoryContract
     */
    private $repository;

    /**
     * FunExpense constructor.
     * @param RepositoryContract $repository
     */
    public function __construct(RepositoryContract $repository)
    {
        $this->repository = $repository;

        $this->setType('fun');
    }

    /**
     * @param int $id
     * @return CoinContract
     * @throws \Exception if not found
     */
    public function view(int $id): CoinContract
    {
        return $this->repository->find($id);
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return CoinContract
     */
    public function charge(float $amount, Carbon $date = null): CoinContract
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
        return $this->repository->update($id, [
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
        return $this->repository->delete($id);
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