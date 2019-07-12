<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    //Overwite laravel functions
    public function login(Request $request){
    

        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }


        //Get user by email or phone number
        $user = \App\User::where('email', $request->input('email'))
                ->select([
                    'id',
                    'password',
                ])
                ->first();
        
        if(!$user){
            //User not found
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

        
        if (!Hash::check($request->input('password'), $user->password)) {
            //Password not matches
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

    
        //Password matches
        //Login user
        auth()->login($user, !!$request->input('remember'));

    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $attempts = 5;
        $lockoutMinites = 10;
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $attempts, $lockoutMinites
        );
    }


    public function sendFailedLoginResponse(Request $request){
        return response()->json(['errors' => [
            'email' => [
                __('auth.failed'),
            ]
        ]], 404);
    }


     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, $service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $service)
    {
        $user = Socialite::driver($service)->user();

        //Get trings receive from social net work
        $id = $user->getId();
        $name = $user->getName();
        $avatar = $user->getAvatar();
        $email = $user->getEmail();

        if(!$email){
            return redirect(url('/login'))->with([
                'error' => [
                    'message' => 'Your '. $service .' account not have email. Please update email address and comeback.',
                    'name' => $name,
                    'avatar' => $avatar,
                ]
            ]);
        }

       

        //Detect first name last name
        $parts = explode(" ", $name);
        $lastName = trim(array_pop($parts));
        $firstName =  trim(implode(" ", $parts));
        $lastName = $lastName?$lastName:null;
        $firstName = $firstName?$firstName:null;
        $service_id = $service . '_id';


        //Get user by email
        $user = \App\User::where('email', $email)->first();

        if($user){
            //Udate service id
            $user->{$service_id} = $id;
            $user->save();

            //User can logged in
            auth()->login($user, true);
        }else{

            //User not exists
            //Create new user
            $user = new \App\User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->{$service_id} = $id;
            $user->email_verified_at = now();
            $user->type = 'member';
            $user->save();

            // //Save avatar from social network
            // $ava = 'avatars/'. $user->id . '/'. uniqid() . '.jpg';
            // Storage::disk('public')->put($ava, file_get_contents($avatar));
            // $user->avatar = $ava;
            // $user->save();

            auth()->login($user, true);
        }
        
        return redirect(url('/login'));
    }

}
