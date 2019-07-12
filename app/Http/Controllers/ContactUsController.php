<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


class ContactUsController extends Controller
{
    public function send(Request $request){

        Validator::make($request->input(), [
            'email' => [
                Rule::requiredIf(!auth()->check()),
                'email'
            ],
            'message' => 'required',
            'url' => 'required|url'
        ])->validate();

        Mail::to(env('ADMIN_NOTIFY_EMAIL'))
            ->send(new \App\Mail\ContactUs([
                'email' => auth()->check() ? auth()->user()->email : $request->input('email'),
                'message' => $request->input('message'),
                'url' => $request->input('url')
            ]));
    }
}
