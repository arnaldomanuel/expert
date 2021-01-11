<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGrant extends Model
{
    const APPROVED = '1';
    const UNPROCESSED = '0';
    const REPROVED = '2';

    use HasFactory;
    //authroize state
    //0 unprocessed
    //1 aproved
    //2 reprovado
    public function user(){
        return $this->belongsTo('App\Models\CourseGrant');
    }
}
