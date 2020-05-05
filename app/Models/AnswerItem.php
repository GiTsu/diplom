<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerItem extends Model
{
    public $timestamps = false;

    public $fillable = [
        'result_id',
        'question_id',
        'question_item_id',
        'answer_id',
        'value',
    ];

    public function questionItem()
    {
        return $this->belongsTo(QuestionItem::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
