<?php

namespace App\Models;

use App\User;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use Filterable;

    public $timestamps = false;

    protected $fillable = ['test_id', 'user_id', 'start_at'];
    protected $dates = ['start_at', 'end_at'];


    public static function getMarkArr()
    {
        return [
            2 => 'Неудовлетворительно (2)',
            3 => 'Удовлетворительно (3)',
            4 => 'Хорошо (4)',
            5 => 'Отлично (5)',
        ];
    }

    public function answers()
    {
        return $this->hasMany(AnswerItem::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
