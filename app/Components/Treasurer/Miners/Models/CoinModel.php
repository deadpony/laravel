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
        'type', 'amount',
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
        return parent::fill($input);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
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

}