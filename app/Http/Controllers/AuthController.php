<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ],
        [
            'required' => 'Please fill in the :attribute field'
         ]
    );
 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $success['token'] =  $user->createToken('Task')->accessToken;
        $success['name'] =  $user->name;
        
        return response()->json([$success, 'User register successfully.'], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Task')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   

}
