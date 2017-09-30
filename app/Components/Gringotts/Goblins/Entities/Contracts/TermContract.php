<?php

namespace App\Components\Gringotts\Goblins\Entities\Contracts;

use App\Helpers\Entities\Contracts\Composable;
use Carbon\Carbon;

interface TermContract extends Composable
{

    /**
     * @return int
     */
    public function getID(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setID(int $id): void;

    /**
     * @return int
     */
    public function getMonths(): int;

    /**
     * @param int $months
     * @return void
     */
    public function setMonths(int $months): void;

    /**
     * @return float
     */
    public function getSetupFee(): float;

    /**
     * @param float $fee
     * @return void
     */
    public function setSetupFee(float $fee): void;

    /**
     * @return float
     */
    public function getMonthlyFee(): float;

    /**
     * @param float $fee
     * @return void
     */
    public function setMonthlyFee(float $fee): void;

    /**
     * @return int
     */
    public function getThresholdDay(): int;

    /**
     * @param int $day
     * @return void
     */
    public function setThresholdDay(int $day): void;

    /**
     * @return Carbon
     */
    public function getDeadlineDate(): Carbon;

    /**
     * @param Carbon $date
     * @return void
     */
    public function setDeadlineDate(Carbon $date): void;

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon;

    /**
     * @param Carbon $createdAt
     * @return void
     */
    public function setCreatedAt(Carbon $createdAt): void;
}
