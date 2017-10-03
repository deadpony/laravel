<?php

namespace App\Components\Gringotts\Goblins\Contracts;

use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface GoblinContract
{

    /**
     * @param int $id
     * @return AccountContract
     * @throws \Exception if not found
     */
    public function view(int $id): AccountContract;

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function open(float $amount, Carbon $date = null): AccountContract;

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return AccountContract
     */
    public function change(int $id, float $amount, Carbon $date = null): AccountContract;

    /**
     * @param int $id
     * @return bool
     */
    public function close(int $id): bool;

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
    public function acceptTerm(AccountContract $account, int $months, Carbon $deadlineDate, Carbon $date = null, float $setupFee = 0, float $monthlyFee = 0, int $thresholdDay = 0): AccountContract;

    /**
     * @return float
     */
    public function debt(): float;

    /**
     * @return Collection
     */
    public function debtList(): Collection;

}