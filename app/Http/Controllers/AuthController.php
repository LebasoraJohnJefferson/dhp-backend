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


use App\Http\Requests\Core\ForgotPasswordRequest;
use App\Http\Requests\Core\ResetPasswordRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){
        $credentails = $request->validated();



        $user = User::where('email',$request->email)
            ->first();

        if(!Auth::attempt($credentails) || $user && $user->is_deleted){
            return $this->error('','Account does not exist!', 404);
        }

        if($user && !$user->is_active){
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

    public function forgotpassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $status
            : $status;
    }




    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $user = User::where('reset_password_token', $token)->first();

        if (!$user) {
            return $this->error('', 'Invalid token', 404);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_token' => null,
        ]);

        return $this->success([
            'message' => 'Password reset successfully',
        ]);
    }

}
