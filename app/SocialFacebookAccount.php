<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialFacebookAccount extends Model
{
    protected $fillable=['id','user_id','provider_user_id','provider'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
