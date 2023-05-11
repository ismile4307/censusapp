<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserType;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=$this->getAllUser();
        // return $users;
        return view('admin.user.home',['users'=>$users]);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the shark
        $user = User::with('organization')->with('user_type')->find($id);
        $organizations=Organization::All()->where('status', 1);
        $user_types=UserType::All()->where('status', 1);
        //return $user;
        // show the view and pass the shark to it




        
        return view('admin.user.edit',['user'=>$user,'organizations'=>$organizations,'user_types'=>$user_types]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request;

        $user = User::find($id);
        $user->organization_id = $request->input('organization_id');
        $user->user_type_id = $request->input('user_type_id');
        $user->status = $request->input('status');
        $user->update();
        
        //return redirect()->back()->with('status','Student Updated Successfully');
        $users=$this->getAllUser();

        return view('admin.user.home',['users'=>$users]);
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

    public function getAllUser()
    {
        $users=User::with('organization')->with('user_type')->get();//->paginate(5);
        return $users;
    }

    public function change_password_index(){
        return view('admin.user.change_password');
    }

    public function reset_password_index($id){
        $user = User::find($id);
        return view('admin.reset_password',['user'=>$user]);
    }

    public function reset_password(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        $confirm_password=$request->input('password_confirmation');

        // dd($request);

        $user = User::find($id);
        return view('admin.reset_password',['user'=>$user]);
    }
}
