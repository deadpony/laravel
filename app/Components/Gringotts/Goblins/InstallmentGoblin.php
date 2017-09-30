<?php

namespace App\Components\Gringotts\Goblins;

use App\Components\Gringotts\Goblins\Entities\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InstallmentGoblin extends AbstractGoblin
{
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

        $this->setType('installment');
    }

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function view(int $id): AccountContract
    {
        return $this->repository->find($id);
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function open(float $amount, Carbon $date = null): AccountContract
    {
        return $this->repository->create(
            [
                'type' => $this->getType(),
                'amount' => $amount,
                'created_at' => $date ?? Carbon::now(),
            ]
        );
    }

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function change(int $id, float $amount, Carbon $date = null): AccountContract
    {
        return $this->repository->update($id, [
            'type' => $this->getType(),
            'amount' => $amount,
            'created_at' => $date ?? Carbon::now(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function close(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return float
     */
    public function debt(): float
    {
        $debt = $this->repository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);

        return floatval($debt->sum(function (AccountContract $account) {
            return $account->getAmount();
        }));
    }

    /**
     * @return Collection
     */
    public function debtList(): Collection
    {
        return $this->repository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);
    }
}