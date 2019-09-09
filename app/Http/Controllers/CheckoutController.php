<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use App\User;

class CheckoutController extends Controller
{
    public function page($id){

        $posts = User::find($id)->posts;
        return view('pay.index')->with('posts',$posts);

    }

    public function index(){
        return view('chat.show');
    }
    public function pay($price){

        
        
        //dd(request()->all());
        Stripe::setApiKey("sk_test_qYXUkTr1jeFeFNdjkhjuECXD007Pstdrwa"); //シークレットキー
 
         $charge = Charge::create([
             'amount' => $price *100,
             'currency' => 'usd',
             'description' => 'home abroad',
            'source'=> request()->stripeToken,
         ]);

        //  dd($charge);
         Session::flash('success','Purchase successfully');
      return redirect('/');
     }

     public function select(Request $request,$id){
        $selectValue = $request->input('weeks');
        $posts = User::find($id)->posts;
        
       
        return view('pay.index')->with('selectValue',$selectValue)->with('posts',$posts);
     }
     public function show($id){
        $posts = User::find($id)->posts;
       
         return view('pay.index')->with('posts',$posts);
     }
}
