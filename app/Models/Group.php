<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = ['id'];
    public $timestamps = null;

    public function students()
    {
        return $this->hasMany(User::class);
    }
}
