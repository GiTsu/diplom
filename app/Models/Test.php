<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'rel_tests_questions');
    }
}
