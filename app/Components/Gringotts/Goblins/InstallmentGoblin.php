<?php

namespace App\Components\Gringotts\Goblins;

use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract as AccountRepositoryContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InstallmentGoblin extends AbstractGoblin
{
    /**
     * @var AccountRepositoryContract
     */
    private $accountRepository;

    /**
     * SalaryMiner constructor.
     * @param AccountRepositoryContract $accountRepository
     */
    public function __construct(AccountRepositoryContract $accountRepository)
    {
        $this->accountRepository = $accountRepository;

        $this->setType('installment');
    }

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function view(int $id): AccountContract
    {
        return $this->accountRepository->find($id);
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function open(float $amount, Carbon $date = null): AccountContract
    {
        return $this->accountRepository->create(
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
        return $this->accountRepository->update($id, [
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
        return $this->accountRepository->delete($id);
    }

    /**
     * @param AccountContract $account
     * @param int $months
     * @param Carbon $deadlineDate
     * @param Carbon|null $date
     * @param float $setupFee
     * @param float $monthlyFee
     * @param int $thresholdDay
     * @return AccountContract
     */
    public function acceptTerm(
        AccountContract $account,
        int $months,
        Carbon $deadlineDate,
        Carbon $date = null,
        float $setupFee = 0,
        float $monthlyFee = 0,
        int $thresholdDay = 0
    ): AccountContract {
        try {
            return $this->accountRepository->updateTerm(
                $account->getTerm(),
                [
                    'months' => $months,
                    'deadline_date' => $date ?? Carbon::now(),
                    'created_at' => $date ?? Carbon::now(),
                    'setup_fee' => $setupFee,
                    'monthly_fee' => $monthlyFee,
                    'threshold_day' => $thresholdDay,
                ]
            );
        } catch (\Exception $ex) {
            return $this->accountRepository->createTerm(
                $account,
                [
                    'months' => $months,
                    'deadline_date' => $date ?? Carbon::now(),
                    'created_at' => $date ?? Carbon::now(),
                    'setup_fee' => $setupFee,
                    'monthly_fee' => $monthlyFee,
                    'threshold_day' => $thresholdDay,
                ]
            );
        }
    }

    /**
     * @return float
     */
    public function debt(): float
    {
        $debt = $this->accountRepository->all([
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
        return $this->accountRepository->all([
            'type' => [
                'value' => $this->getType(),
            ]
        ]);
    }
}