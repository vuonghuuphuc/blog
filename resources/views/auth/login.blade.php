@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg animated fadeInDown">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            <img src="{{ session('error.avatar') }}" style="width: 40px; height:40px" alt="avatar" class="rounded-circle">
                            <br>
                            <strong>{{ session('error.name') }}</strong>
                            <div class="mt-2">
                                {{ session('error.message') }}
                            </div>
                        </div>
                    @endif
                    
                    @component('components.auth.form_login')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
