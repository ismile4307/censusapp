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
}
