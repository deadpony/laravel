<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface TermContract {

    /**
     * @return TermContract
     */
    public function scratch() : TermContract;

    /**
     * @param array $input
     * @return TermContract
     */
    public function fill(array $input) : TermContract;

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []) : Collection;

    /**
     * @param int $id
     * @return TermContract
     */
    public function find(int $id) : TermContract;

    /**
     * @return TermContract
     */
    public function performSave() : TermContract;

    /**
     * @return bool
     */
    public function performDelete() : bool;

    /**
     * @return array
     */
    public function presentAsArray() : array;

    /**
     * @return int
     */
    public function getMonths() : int;

    /**
     * @param int $months
     * @return TermContract
     */
    public function setMonths(int $months) : TermContract;

    /**
     * @return float
     */
    public function getSetupFee() : float;

    /**
     * @param float $fee
     * @return TermContract
     */
    public function setSetupFee(float $fee) : TermContract;

    /**
     * @return float
     */
    public function getMonthlyFee() : float;

    /**
     * @param float $fee
     * @return TermContract
     */
    public function setMonthlyFee(float $fee) : TermContract;

    /**
     * @return int
     */
    public function getThresholdDay() : int;

    /**
     * @param int $day
     * @return TermContract
     */
    public function setThresholdDay(int $day) : TermContract;

    /**
     * @return Carbon
     */
    public function getDeadlineDate() : Carbon;

    /**
     * @param Carbon $date
     * @return TermContract
     */
    public function setDeadlineDate(Carbon $date) : TermContract;
}
