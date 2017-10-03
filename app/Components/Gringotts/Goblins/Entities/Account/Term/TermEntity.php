<?php

namespace App\Components\Gringotts\Goblins\Entities\Account\Term;

use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Entities\Account\Term\Contracts\TermContract;
use App\Helpers\Entities\Composable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TermEntity extends Composable implements TermContract
{

    /** @var Collection */
    private $storage;

    public function __construct()
    {
        $this->storage = collect([]);
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->storage->get('id');
    }

    /**
     * @param int $id
     * @return void
     */
    public function setID(int $id): void
    {
        $this->storage->put('id', $id);
    }

    /**
     * @return int
     */
    public function getMonths(): int
    {
        return $this->storage->get('months');
    }

    /**
     * @param int $months
     * @return void
     */
    public function setMonths(int $months): void
    {
        $this->storage->put('months', $months);
    }

    /**
     * @return float
     */
    public function getSetupFee(): float
    {
        return $this->storage->get('setup_fee');
    }

    /**
     * @param float $fee
     * @return void
     */
    public function setSetupFee(float $fee): void
    {
        $this->storage->put('setup_fee', $fee);
    }

    /**
     * @return float
     */
    public function getMonthlyFee(): float
    {
        return $this->storage->get('monthly_fee');
    }

    /**
     * @param float $fee
     * @return void
     */
    public function setMonthlyFee(float $fee): void
    {
        $this->storage->put('setup_fee', $fee);
    }

    /**
     * @return int
     */
    public function getThresholdDay(): int
    {
        return $this->storage->get('threshold_day');
    }

    /**
     * @param int $day
     * @return void
     */
    public function setThresholdDay(int $day): void
    {
        $this->storage->put('threshold_day', $day);
    }

    /**
     * @return Carbon
     */
    public function getDeadlineDate(): Carbon
    {
        return $this->storage->get('deadline_date');
    }

    /**
     * @param Carbon $date
     * @return void
     */
    public function setDeadlineDate(Carbon $date): void
    {
        $this->storage->put('deadline_date', $date);
    }


    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->storage->get('created_at');
    }

    /**
     * @param Carbon $createdAt
     * @return void
     */
    public function setCreatedAt(Carbon $createdAt): void
    {
        $this->storage->put('created_at', $createdAt);
    }

    /**
     * @return AccountContract
     */
    public function getAccount(): AccountContract
    {
        return $this->storage->get('account');
    }

    /**
     * @param AccountContract $account
     */
    public function setAccount(AccountContract $account): void
    {
        $this->storage->put('account', $account);
    }


}