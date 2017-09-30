<?php

namespace App\Components\Gringotts\Goblins\Models;

use App\Helpers\Models\Eloquent\Eloquent;

class TermModel extends Eloquent
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
}