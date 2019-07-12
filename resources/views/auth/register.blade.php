@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg animated fadeInDown">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    
                    @component('components.auth.form_register')
                    @endcomponent

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
