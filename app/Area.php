<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable=['area'];
    public function posts(){
        return $this->hasMany('App\Post');
     }
}
