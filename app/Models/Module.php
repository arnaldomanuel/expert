<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function lessons(){
        return $this->hasMany('App\Models\Lesson');
    }
    public function course(){
        return $this->belongsTo('App\Models\Course');
    }
}
