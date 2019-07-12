<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function getLogin(){

        if(auth()->check()){
            return redirect(adminUrl('/dashboard'));
        }

        return view('admin.auth.login');
    }

    public function postLogin(Request $request){

        

        //Logout current admin
        auth()->logout();

        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();;

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }


        //Get admin by username
        $admin = \App\User::admin()
            ->where('email', $request->input('email'))
            ->select([
                'id',
                'password',
                'is_banned'
            ])
            ->first();

        
        if(!$admin){
            //Admin not found
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
                
        if($admin->is_banned){
            //Admin is banned
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request, __('auth.banned'));
        }

        //Check password
        if (!Hash::check($request->input('password'), $admin->password)) {
            //Password not matches
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }


        //Login admin
        auth()->login($admin);

        
    }

    public function username()
    {
        return 'email';
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $attempts = 5;
        $lockoutMinites = 10;
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $attempts, $lockoutMinites
        );
    }

    public function sendFailedLoginResponse(Request $request, $message = null){
        return response()->json(['errors' => [
            'email' => [
                $message ?? __('auth.failed'),
            ]
        ]], 404);
    }

    public function postLogout(){
        auth()->logout();
        return redirect(adminUrl('/login'));
    }
}
