<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('role')->paginate(10);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);  

        $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => bcrypt($request->password),
              'api_token' => str_random(100)
           ]);

        $role = Role::where('id',$request->role)->first();
        $user->attachRole($role);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('role')->whereId($id)->first();
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
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,'.$id,
            'role' => 'required'
        ]);  

        $user = User::with('role')->whereId($id);

        $role_lama = Role::where('id',$user->first()->role->role_id)->first();

        $user->update([
              'name' => $request->name,
              'email' => $request->email,
           ]);

        $role = Role::where('id',$request->role)->first();
        $user->detachRole($role_lama);
        $user->attachRole($role);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->detachRole($user->role->role_id);
        $user->destroy($id);
        return response(200);
    }
}
