<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'rel_tests_questions');
    }

    public function questionItems()
    {
        return $this->belongsToMany(QuestionItem::class, 'rel_questions_items');
    }
}
