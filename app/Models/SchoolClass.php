<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable=['class_name', 'start_lesson', 'course_id', 'active'];
    protected $with=['courseGrants'];
   


    public function course(){
        return $this->belongsTo('App\Models\Course');
    }
    public function courseGrants(){
        return $this->hasMany('App\Models\CourseGrant', 'school_classs_id');
    }
}
