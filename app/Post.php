<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','price','price_id','user_id','area_id','study_id','image','message'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function area(){
        return $this->belongsTo('App\Area');
    }
    public function study(){
        return $this->belongsTo('App\Study');
    }
    public function price(){
        return $this->belongsTo('App\Price');
    }
}
