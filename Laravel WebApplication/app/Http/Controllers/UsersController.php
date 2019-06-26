<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\TeamMembers;
use App\Team;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['users']=User::paginate(10);
        return view('users.main', $data);
        

    }

    public function viewProfile()
    {

        $data = User::findOrFail(Auth::user()->id);
        return view('users.profile', compact('data'));
      

    }

    public function editProfile()
    {

        $data = User::findOrFail(Auth::user()->id);
        return view('users.editprofile', compact('data'));
      

    }

    public function updateProfile($id, Request $request)
    {

        if(Auth::user()->id == $id){
        $userDataToReplace = request()->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'user_chat_id' => 'integer|min: 0',
            'password' => 'required|string|min: 8|confirmed'
        ]);

        User::where('id', '=' ,$id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'user_chat_id' => $request['user_chat_id'],
            'password' => Hash::make($request['password']),
        ]);
 
        return redirect()->route("profile-view", [$id])->with('success', 'All changes to your profile have been made');
        }
        else{
            "die";
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $listofroles = Role::all('role_name', 'role_id');

        return view('users.create', compact('listofroles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newUserFromAdmin = request()->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:users',
            'email' => 'required|email|unique:users',
            'user_chat_id' => 'integer|min: 0',
            'user_role_id' => 'exists:roles,role_id',
            'active' => 'required|integer|min: 1|max: 1',
            'password' => 'required|string|min: 8|confirmed'
        ]);
    
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'user_chat_id' => $request['user_chat_id'],
            'user_role_id' => $request['user_role_id'],
            'active' => $request['active'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route("users-main")->with('success', 'The user was successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UsersManagement  $usersManagement
     * @return \Illuminate\Http\Response
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsersManagement  $usersManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $listofroles = Role::all('role_name', 'role_id');
    
        return view('users.edit', compact('user', 'listofroles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsersManagement  $usersManagement
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {   
        
       $userDataToReplace = request()->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
           'user_chat_id' => 'integer|min: 0',
           'user_role_id' => 'exists:roles,role_id',
           'active' => 'required|integer|min: 1|max: 2'
       ]);
       User::where('id', '=' ,$id)->update($userDataToReplace);


       return redirect()->route("users-edit", [$id])->with('success', 'All changes to the user data have been successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersManagement  $usersManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route("users-main")->with('success', 'The user was successfully deleted');
    }
}
