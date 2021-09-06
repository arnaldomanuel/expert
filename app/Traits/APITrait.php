<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait APITrait
{
    public function isAPI(Request  $request){
        return Str::contains($request->path(),'api');
    }
}
