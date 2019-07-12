<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function getUpdate(){
        return view('auth.password');
    }

    public function postUpdate(Request $request){
        
        Validator::make($request->input(), [
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();



        //Check old password
        if (!Hash::check($request->input('old_password'), auth()->user()->password)) {
            //Password not matches
            return response()->json(['errors' => [
                'old_password' => [
                    __('Current password incorrect.'),
                ]
            ]], 404);
        }

        //Update password
        $admin = auth()->user();
        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        //Logout
        auth()->logout();
    }
}
