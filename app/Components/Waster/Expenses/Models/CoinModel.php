<?php

namespace App\Components\Waster\Expenses\Models;

use App\Helpers\Models\Eloquent\Eloquent;

class CoinModel extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'amount',
        'created_at'
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
    protected $table = 'expense';

}