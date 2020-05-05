<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public $timestamps = false;

    protected $fillable = ['test_id', 'user_id', 'start_at'];
    protected $dates = ['start_at', 'end_at'];


    public static function getMarkArr()
    {
        return [
            2 => 'неудовлетворительно',
            3 => 'Удовлетворительно',
            4 => 'Хорошо',
            5 => 'Отлично',
        ];
    }

    public function answers()
    {
        return $this->hasMany(AnswerItem::class);
    }
}
