<?php

namespace App\Components\Gringotts\Goblins;

use App\Components\Gringotts\Goblins\Contracts\Abilities\TermableContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract;

use \App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\RepositoryContract as RepositoryOfTermsContract;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class CreditGoblin extends AbstractGoblin
{
    /**
     * @var RepositoryContract
     */
    private $repository;

    /**
     * @var RepositoryOfTermsContract
     */
    private $repositoryOfTerms;

    /**
     * @var array
     */
    private $term = [];

    /**
     * SalaryMiner constructor.
     * @param RepositoryContract $repository
     * @param RepositoryOfTermsContract $repositoryOfTerms
     */
    public function __construct(RepositoryContract $repository, RepositoryOfTermsContract $repositoryOfTerms)
    {
        $this->repository = $repository;
        $this->repositoryOfTerms = $repositoryOfTerms;

        $this->setType('credit');
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function open(float $amount, Carbon $date = null): bool
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
     * @return bool
     */
    public function change(int $id, float $amount, Carbon $date = null): bool
    {
        $account = $this->repository->find($id);

        return $this->repository->update($account, [
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
        $account = $this->repository->find($id);

        return $this->repository->delete($account);
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