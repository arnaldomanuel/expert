<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'first', 'second', 'third', 'fourth', 'correct_index', 'module_id'];

    public function module(){
        return $this->belongsTo('App\Models\Module');
    }
}
