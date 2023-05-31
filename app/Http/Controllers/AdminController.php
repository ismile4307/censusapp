<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use App\Models\UserType;

use Auth;

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
        return view('admin.reset_password',['user'=>$user,'msg' =>'']);
    }

    public function change_password(Request $request){
        $password_old=$request->input('password_old');
        $password_new=$request->input('password_new');
        $password_confirmation=$request->input('password_confirmation');
        
        // if(strlen($password_new)<8)
        // {
            // $request->session()->flash('error', 'Minium 8 charecter should be requried');
            // return redirect()->route('your.route');
            // return Redirect::back()->withErrors(['msg' => 'Minium 8 charecter should be requried']);
        // }
        /*
        * Validate all input fields
        */
        // $this->validate($request, [
        //     'password' => 'required',
        //     'new_password' => 'confirmed|max:8|different:password',
        // ]);

        if (Hash::check($request->password_old, Auth::user()->password)) { 
        // $user->fill([
        //     'password' => Hash::make($request->new_password)
        //     ])->save();

        // $request->session()->flash('success', 'Password changed');
        //     return redirect()->route('your.route');
            // dd("password Match");
            
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($password_new);
            $user->update();

            return Redirect::back()->withErrors(['msg' => 'Password has been changed successfully']);

        } else {
            return Redirect::back()->withErrors(['msg' => 'Old password not matched']);
            // $request->session()->flash('error', 'Password does not match');
            // return redirect()->route('your.route');

        }

        // Hash::make($password_old)
    }

    public function reset_password(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        $confirm_password=$request->input('password_confirmation');

        $user = User::find($id);
        $user->password = Hash::make($password);
        $user->update();

        $user = User::find($id);
        // return Redirect::back()->withErrors(['user'=>$user,'msg' => 'Password has been changed successfully']);

        return view('admin.reset_password',['user'=>$user,'msg' => 'Password has been changed successfully']);
    }
}
