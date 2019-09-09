<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.profile.edit')->with('user',Auth::user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {   
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email'
        ]);
        $disk = Storage::disk('s3');

        $user = Auth::user();

        // if($request->hasFile('avatar')){
        //     $avatar = $request->avatar;
        //     $avatar_new_name = time().$avatar->getClientOriginalName();
        //     $avatar->move('uploads/avatar',$avatar_new_name);
        //     $user->avatar = 'uploads/avatar/'.$avatar_new_name;
        //     $user->save();
        // }
        if($request->hasFile('avatar')){
            $path = $disk->put('avatar',$request->file('avatar'),'public');
            $user->avatar = Storage::disk('s3')->url($path);
            $user->save();
        }
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->has('password')){
            $user->password = bcrypt($request->password);
            $user->save();
        }
        $user->save();

        Session::flash('success','Account profile updated');
        return redirect()->back();
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
