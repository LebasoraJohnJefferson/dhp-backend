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

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    public function resetpassword(Request $request, $token)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}
