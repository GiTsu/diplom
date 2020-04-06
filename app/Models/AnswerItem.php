<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerItem extends Model
{
    public $timestamps = false;

    public $fillable = [
        'user_id',
        'test_id',
        'question_id',
        'answer_id',
        'value',
    ];
}
