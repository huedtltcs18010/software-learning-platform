<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'series';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
