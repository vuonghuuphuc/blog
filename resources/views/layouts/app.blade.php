@extends('layouts.core')

@section('app')
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand animated heartBeat" href="{{ url('/') }}">
            <i class="fa fa-tools"></i>
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" data-toggle="modal" data-target="#modal-contact-us">
                        <i class="fa fa-envelope"></i>
                        {{ __('Contact Us') }}
                    </a>
                </li>
                <!-- Authentication Links -->
                @guest
                {{-- <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('login') }}">
                        <i class="fa fa-sign-in-alt"></i>
                        {{ __('Login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('register') }}">
                        <i class="fa fa-user-plus"></i>
                        {{ __('Register') }}
                    </a>
                </li> --}}
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class=" text-light nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-user"></i>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        @if (auth()->user()->is_admin)
                            <a href="{{ adminUrl('/dashboard') }}" target="_blank" class="dropdown-item">
                                <i class="fa fa-cogs"></i>
                                {{ __('Admin Control Panel') }}
                            </a>
                        @endif

                        <a href="{{ url('/password') }}" class="dropdown-item">
                            <i class="fa fa-key"></i>
                            {{ __('Change Password') }}
                        </a>
                        
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" id="modal-contact-us">
    <div class="modal-dialog shadow-lg" role="document">
        <form id="form-contact-us" action="{{ url('/contact-us') }}" method="POST">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title">{{ __('Contact Us') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="url" value="{{ url()->full() }}">

                    @guest
                    @include('includes.form_group_input', [
                        'label' => __('E-Mail Address'),
                        'name' => 'email',
                        'dataValidation' => 'required email'
                    ])
                    @endguest
    
                    @include('includes.form_group_textarea', [
                        'label' => __('Message'),
                        'name' => 'message',
                        'dataValidation' => 'required',
                        'formGroupClass' => 'form-group mb-0'
                    ])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-dark">
                        <i class="fa fa-paper-plane"></i>
                        {{ __('Send') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<main class="py-4">
    @if (auth()->check())
        @if (!auth()->user()->email_verified_at)
        <div class="container mb-4">
            <div class="card shadow-lg animated pulse">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-dark" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>        
        </div>
        @endif
    @endif
    @yield('content')
</main>
@endsection

@push('layoutStyles')
<style>
    body {
        background-color: rgba(0, 0, 0, 0.075);
        padding-top: 45px;
        background: url('{{ asset("images/bg.png") }}') repeat;
    }
</style>
@endpush


@push('scripts')
<script>
$(document).ready(function(){
    var modalContactUs = $('#modal-contact-us');
    var formContactUs = $('#form-contact-us');
    
    formContactUs.toAjaxAndValidateForm({
        success: function(){
            modalContactUs.modal('hide');

            Swal.fire({
                title: '{{ __("SUCCESS") }}',
                text: '{{ __("Your message is sent!") }}',
                type: 'success',
            });
        }
    });

    modalContactUs.on('hidden.bs.modal', function (e) {
        formContactUs.resetForm();
    });
    modalContactUs.on('shown.bs.modal', function (e) {
        formContactUs.find('[name="email"]').focus();
    });
});
</script>
@endpush