<?php

namespace App;

use App\Models\AnswerItem;
use App\Models\Group;
use App\Models\Result;
use App\Models\Test;
use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;

class User extends Authenticatable
{
    use Notifiable, HasRole, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function answers()
    {
        return $this->hasMany(AnswerItem::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

}
