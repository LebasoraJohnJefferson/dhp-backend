<?php

namespace App\Http\Controllers;

use App\Http\Requests\Core\LoginUserRequest;
use App\Http\Requests\core\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){
        $credentails = $request->validated();

        if(!Auth::attempt($credentails)){
            return $this->error('','Account does not exist!', 404); 
        }
        $user = User::where('email',$request->email)
            ->where('is_active',true)
            ->first();

        if(!$user){
            return $this->error('','Account Restriced!', 401);
        }
        
        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
        
    }

    public function register(StoreUserRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'is_active'=>$request->is_active
        ]);
        
        return $this->success([
            'user'=>$user,
            'token'=> $user->createToken('API token of' . $user->name)->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message'=>"Logout successfully"
        ]);
    }

}
