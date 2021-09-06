<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with=["user"];

    protected $filable = [
        'name', 'description', 'thumbnail', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function modules(){
        return $this->hasMany('App\Models\Module');
    }
    public function objectives(){
        return $this->hasMany('App\Models\Objective');
    }
    public function schoolClasses(){
        return $this->hasMany('App\Models\SchoolClass');
    }
}
