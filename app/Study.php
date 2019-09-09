<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $fillable = ['study'];

    public function posts(){
        return $this->hasMany('App\Post');
    }
}
