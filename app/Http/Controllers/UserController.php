<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json(User::findOrFail($id), 200);
    }

    /**
     * Retrive all user from db
     * 
     * @return Response
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Update data the user for the given ID
     * 
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        
        $user->save();
        return response()->json($user, 201);
    }
}
