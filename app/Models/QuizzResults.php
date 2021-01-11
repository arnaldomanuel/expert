<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzResults extends Model
{

    protected $table ="quizzs_results";
    use HasFactory;

    public function module(){
        return $this->belongsTo('App\Models\Module');
    }
}
