<?php
/**
 * MIT License
 *
 * Copyright (c) 2020 Carlos Cortes, Fabian Rojas y Wilber Navarro.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{

    /**
     * Register a user into the system.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function  register(Request $request){

        $data = $request->all();

        //The rules of validation
        $validator = Validator::make($data,[
            'name' => 'required|min:3|max:255',
            'email' => 'email:rfc,dns|required|unique:users',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        //If validation fails, return 412
        if($validator->fails()){
            return response([
                'error'=>'Validation Error',
                'message' => $validator->errors()
            ],412);
        }

        //Apply bcrypt to password (very secure)
        /** @noinspection PhpUndefinedFieldInspection */
        $data['password'] = bcrypt($request->password);

        //Insert the user into the database
        $user = User::create($data);


        $authToken = $user->createToken('authToken');

        //Return the token to the user
        return response([
            'user' => $user,
            'token' => $authToken->accessToken,
            'token_expires_at'=>$authToken->token->expires_at
        ]);

    }

    /**
     * Do the login, returning the access token.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){

        //All the data from the request
        $data = $request->all();

        $validator = Validator::make($data,[
            'email' => 'email:rfc,dns|required',
            'password' => 'required'
        ]);

        //If fails: 401 One or more conditions in the request header fields evaluate to false
        if($validator->fails()){
            return response([
                'error'=>'Validation Error',
                'message' => $validator->errors()
            ],412);
        }

        //Fail: 401 Unauthorized: Client failed to authenticate with the server
        if(!auth()->attempt($data)){
            return response([
                'error'=>'Invalid Credentials',
                'message' => 'Unauthorized, wrong mail or password'
            ],401);
        }
        //The token
        $authToken = auth()->user()->createToken('authToken');
        return response([
            'user' => auth()->user(),
            'token' => $authToken->accessToken,
            'token_expires_at'=>$authToken->token->expires_at
        ]);
    }

    /**
     * Logout user (revoke token)
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response([
           'message'=>'Successfully logged out'
        ]);

    }
}
