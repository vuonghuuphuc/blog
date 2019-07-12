@php ($id = htmlId())
<form id="{{ $id }}" method="POST" action="{{ route('login') }}">

    @include('includes.form_group_input', [
        'label' => __('Email Address'),
        'name' => 'email',
        'icon' => 'fa fa-envelope',
        'dataValidation' => 'required email'
    ])

    @include('includes.form_group_input', [
        'label' => __('Password'),
        'name' => 'password',
        'type' => 'password',
        'icon' => 'fa fa-key',
        'dataValidation' => 'required',
    ])

    <div class="form-group">
        @include('includes.checkbox', [
            'label' => __('Remember Me'),
            'name' => 'remember'
        ])
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-sign-in-alt"></i>
            {{ __('Login') }}
        </button>
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    </div>
    <hr>
    
    @component('components.auth.buttons_social_network')
    @endcomponent
</form>

@push('scripts')
    <script>
        $(document).ready(function(){
            var form = $('#{{ $id }}');
            form.toAjaxAndValidateForm({
                success: function(){
                    reload();
                }
            });
        });
    </script>
@endpush