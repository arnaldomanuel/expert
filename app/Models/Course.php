<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;


    protected $filable = [
        'name', 'description', 'thumbnail', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function modules(){
        return $this->hasMany('App\Models\Module');
    }
}
