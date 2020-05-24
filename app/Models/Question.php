<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Filterable;

    const SINGLE_QUESTION = 0;
    const MULTI_QUESTION = 1;
    const ENTER_QUESTION = 2;
    const COMPLY_QUESTION = 3;
    public $timestamps = false;
    protected $fillable = ['type_id', 'subject_id', 'title', 'text'];

    public static function getTypes()
    {
        return [
            self::SINGLE_QUESTION => 'Правильный вариант',
            self::MULTI_QUESTION => 'Несколько правильных вариантов',
            self::ENTER_QUESTION => 'Ввод текста ответа',
            self::COMPLY_QUESTION => 'выбор соответствия',
        ];
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'rel_tests_questions');
    }

    public function questionItems()
    {
        return $this->belongsToMany(QuestionItem::class, 'rel_questions_items');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
