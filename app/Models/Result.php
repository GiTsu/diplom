<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public $timestamps = false;

    protected $fillable = ['test_id', 'user_id', 'start'];
    protected $dates = ['start_at', 'end_at'];
}
