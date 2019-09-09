<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use App\Services\SocialFacebookAccountService;

class SocialFacebookController extends Controller
{
    public function redirect(){
        return Socialite::driver('facebook')->redirect(); //facebookへいく
    }
    public function callback(SocialFacebookAccountService $service){
        $user = $service->createOrGetUser(Socialite::driver('facebook')->stateless()->user());
        auth()->login($user);
        return redirect()->to('/profile');
    }
}