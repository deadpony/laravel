<?php

namespace App\Components\Gringotts\Goblins\Models;

use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\HasTermContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\TermContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AccountModel extends Model implements AccountContract, HasTermContract
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'amount', 'created_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @return AccountContract
     */
    public function scratch(): AccountContract
    {
        return $this->newInstance();
    }

    /**
     * @param array $input
     * @return AccountContract
     */
    public function fill(array $input) : AccountContract
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
     * @return AccountContract
     */
    public function find(int $id) : AccountContract
    {
        return $this->newQuery()->find($id);
    }

    /**
     * @return AccountContract
     */
    public function performSave(): AccountContract
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
     * @return string
     */
    public function getType(): string
    {
        return strval($this->getAttribute('type'));
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return floatval($this->getAttribute('amount'));
    }

    /**
     * @return TermContract
     */
    public function term(): TermContract
    {
        $term = $this->hasOne(TermContract::class, 'account_id', 'id')->getResults();

        return $term;
    }

}