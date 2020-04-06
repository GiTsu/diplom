<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['text', 'is_correct', 'linked_id'];
}
