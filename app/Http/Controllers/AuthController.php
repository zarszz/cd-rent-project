<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    /**
     * Create new user to database
     * 
     * @param Request $request
     * @return Response
     */
    public function register(Request $request){
        try{
            $user = new User;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->address = $request->address;      

            $plainPassword = $request->password;
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            return ['user' => $user, 'status' => 'CREATED', 'status' => 201];
        } catch (\Exception $e){
            return ['message' => 'Registration failed', 'status' => 409];
        }
    }

    /**
     * Get a JWT with given credentials
     * 
     * @param Request $request
     * @param Response
     */
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        if (! $token = Auth::attempt($credentials)) {
            return ['message' => 'unauthorized', 'code' => 401];
        }
        return $this->respondWithToken($token);
    }
}
