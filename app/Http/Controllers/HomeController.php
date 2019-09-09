<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Area;
use App\Study;
use App\Price;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function list(){
        $posts = Post::all();
        $users = User::all();
        $areas = Area::all();
        $studies = Study::all();
        $prices = Price::all();
        
        return view('welcome')->with('posts',$posts)->with('users',$users)->with('areas',$areas)->with('studies',$studies)->with('prices',$prices);
    }
    public function single(Post $post){
        return view('single')->with('post',$post)->with('user',Auth::user());
    }

    public function search()
{
    
    $searchPrice = request('price');
    $searchArea = request('area');
    $searchStudy = request('study');

    $posts = null;

    if($searchPrice || $searchArea || $searchStudy) {
        $posts = Post::when($searchArea, function ($query) use ($searchArea) {
                return $query->whereHas('area', function ($query) use ($searchArea) {
                    $query->where('id', $searchArea);
                });
            })
            ->when($searchStudy, function ($query) use ($searchStudy) {
                return $query->whereHas('study', function ($query) use ($searchStudy) {
                    $query->where('id', $searchStudy);
                });
            })
            ->when($searchPrice, function ($query) use ($searchPrice) {
                return $query->whereHas('price', function ($query) use ($searchPrice) {
                    $query->where('id', $searchPrice);
                });
            })
            ->paginate(2)
            ->appends(request()->query());
    }

  return view('searchresult', compact('posts'));
}
    
    
}

