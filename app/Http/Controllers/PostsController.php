<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use Session;
use App\User;
use App\Area;
use App\Study;
use App\Price;
use Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $areas = Area::all();
        $studies = Study::all();
        $prices = Price::all();
        return view('auth.profile.create')->with('areas',$areas)->with('studies',$studies)->with('prices',$prices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'price'=>'required',
            'price_id'=>'required',
            'area_id'=>'required',
            'study_id'=>'required',
            'message'=>'required',
            'image'=>'required|image'
        ]);

        // $image = $request->image;

        // $image_new_name = time().$image->getClientOriginalName();

        // $image->move('uploads/posts',$image_new_name);
        
        $image = $request->image;
        // バケットの`myprefix`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
        // $path = Storage::disk('s3')->putFile('myprefix', $image);
        // アップロードした画像のフルパスを取得
        $url = Storage::disk('s3')->url($path);
        // $disk = Storage::disk('s3');

        // if($request->hasfile('image')){
        //     $path = $disk->put('image',$request->file('image'),'public');
        //     $url = Storage::disk('s3')->url($path);
        // }

        $user_id = Auth::id();

        $post = Post::create([
            'title' => $request->title,
            'price' =>$request->price,
            'price_id'=>$request->price_id,
            'area_id'=>$request->area_id,
            'study_id'=>$request->study_id,
            'message'=>$request->message,
            'user_id'=>$user_id,
            'image'=> $url
        ]);

        Session::flash('success','Post created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $posts = User::find(Auth::id())->posts;
        return view('post.show')->with('posts',$posts)->with('user',Auth::user());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $areas = Area::all();
        $studies = Study::all();
        $prices = Price::all();
        return view('post.edit')->with('post',$post)->with('areas',$areas)->with('studies',$studies)->with('prices',$prices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title' => 'required',
            'area_id' => 'required',
            'price'=>'required',
            'price_id'=>'required',
            'study_id'=>'required',
            'message'=>'required',
            'image' =>'nullable|image'
        ]);
        $disk = Storage::disk('s3');

        // if($request->hasFile('image')){
        //     $image = $request->image;

        //     $image_new_name = time().$image->getClientOriginalName();

        //      $image->move('uploads/posts',$image_new_name);

        //      $post->image = 'uploads/posts/'.$image_new_name;

        // }
        if($request->hasFile('image')){
            $path = $disk->put('image',$request->file('image'),'public');
            $post->image = Storage::disk('s3')->url($path);
            $post->save();
        }

        $post->title = $request->title;
        $post->area_id = $request->area_id;
        $post->price = $request->price;
        $post->price_id = $request->price_id;
        $post->study_id = $request->study_id;
        $post->message = $request->message;
        $post->save();

            

        Session::flash('success','Post updated successfully');

        return redirect()->route('post.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
