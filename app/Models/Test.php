<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'rel_tests_questions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'rel_users_tests');
    }
}
