<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Register a user into the system.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function  register(Request $request){

        $data = $request->all();

        $validator = Validator::make($data,[
            'name' => 'required|max:50',
            'email' => 'email|required|unique:user',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return response([
                'error'=>$validator->errors(),
                'message' => 'Validator Error'
            ]);
        }

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ]);

    }

    /**
     * Do the login, returning the access token.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){

        $data = $request->all();

        $validator = Validator::make($data,[
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ]);
        }

        if(!auth()->attempt($data)){
            return response([
                'message' => 'Invalid Credentials'
            ]);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response([
            'user' => auth()->user(),
            'acces_token' => $accessToken
        ]);

    }
}
