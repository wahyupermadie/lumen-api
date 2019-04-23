<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;

class AuthUserController extends Controller
{
    public $hasher;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hasher = app()->make('hash');
    }
    
    // Login user
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)
                ->first();
        if($user){
            if($this->hasher->check($request->password,$user->password)){
                $api_token = $user->createToken('userToken')->accessToken;
                $create_token = User::where('id', $user->id)->update(['api_token' => $api_token]);
                if($create_token){
                    $success['token'] =  $api_token;
                    $success['name'] =  $user->name;
                    return response()->json($success,200);
                }
            }else{
                return response()->json([
                    'message' => "Password Anda Salah"
                ],401);
            }
        }else{
            return response()->json([
                'message' => "Email Anda Tidak Terdaftar"
            ],401);
        }
    }

    // Register 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $input = $request->all();
        $input['password'] = $this->hasher->make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('userToken')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], 200);
    }
}