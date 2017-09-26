<?php

namespace App\Components\Treasurer\Miners\Models;

use App\Components\Treasurer\Miners\Repositories\Contracts\CoinContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CoinModel extends Model implements CoinContract {

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
    protected $table = 'coins';


    /**
     * @return CoinContract
     */
    public function scratch(): CoinContract
    {
        return $this->newInstance();
    }

    /**
     * @param array $input
     * @return CoinContract
     */
    public function fill(array $input) : CoinContract
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
     * @return CoinContract
     */
    public function find(int $id) : CoinContract
    {
        return $this->newQuery()->find($id);
    }

    /**
     * @return bool
     */
    public function performSave(): bool
    {
        return $this->save();
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

}