<?php

namespace App\Components\Gringotts\Goblins\Models;

use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\HasAccountContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\TermContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TermModel extends Model implements TermContract, HasAccountContract
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'months', 'setup_fee', 'monthly_fee', 'threshold_day', 'deadline_date', 'created_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'deadline_date',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'terms';

    /**
     * @return TermContract
     */
    public function scratch(): TermContract
    {
        return $this->newInstance();
    }

    /**
     * @param array $input
     * @return TermContract
     */
    public function fill(array $input) : TermContract
    {
        parent::fill($input);

        return $this;
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAll(array $filter = []): Collection
    {
        if ($filter) {
            $query = self::newQuery();

            collect($filter)->each(function($condition, $field) use ($query) {
                if (array_get($condition, 'value')) {
                    $query->{array_get($condition, 'function', 'where')}($field, array_get($condition, 'condition', '='), array_get($condition, 'value'));
                } else {
                    // todo: log this
                }
            });

            return $query->get();
        }

        return self::all();
    }

    /**
     * @param int $id
     * @return TermContract
     */
    public function find(int $id) : TermContract
    {
        return $this->newQuery()->find($id);
    }

    /**
     * @return TermContract
     */
    public function performSave(): TermContract
    {
        $this->save();

        return $this;
    }

    /**
     * @return bool
     */
    public function performDelete(): bool
    {
        return $this->delete();
    }

    /**
     * @return array
     */
    public function presentAsArray(): array
    {
        return $this->toArray();
    }

    /**
     * @return int
     */
    public function getMonths(): int
    {
        return $this->getAttribute('months');
    }

    /**
     * @param int $months
     * @return TermContract
     */
    public function setMonths(int $months): TermContract
    {
        $this->setAttribute('months', $months);

        return $this;
    }

    /**
     * @return float
     */
    public function getSetupFee(): float
    {
        return $this->getAttribute('setup_fee');
    }

    /**
     * @param float $fee
     * @return TermContract
     */
    public function setSetupFee(float $fee): TermContract
    {
        $this->setAttribute('setup_fee', $fee);

        return $this;
    }

    /**
     * @return float
     */
    public function getMonthlyFee(): float
    {
        return $this->getAttribute('monthly_fee');
    }

    /**
     * @param float $fee
     * @return TermContract
     */
    public function setMonthlyFee(float $fee): TermContract
    {
        $this->setAttribute('monthly_fee', $fee);

        return $this;
    }

    /**
     * @return int
     */
    public function getThresholdDay(): int
    {
        return $this->getAttribute('threshold_day');
    }

    /**
     * @param int $day
     * @return TermContract
     */
    public function setThresholdDay(int $day): TermContract
    {
        $this->setAttribute('threshold_day', $day);

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDeadlineDate(): Carbon
    {
        return $this->getAttribute('deadline_date');
    }

    /**
     * @param Carbon $date
     * @return TermContract
     */
    public function setDeadlineDate(Carbon $date): TermContract
    {
        $this->setAttribute('deadline_date', $date);

        return $this;
    }

    /**
     * @return AccountContract
     */
    public function account(): AccountContract
    {
        $account = $this->belongsTo(AccountContract::class, 'account_id', 'id')->getResults();

        return $account;
    }


}