@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card shadow-lg animated fadeInDown">
                <div class="card-header">
                    <i class="fa fa-key"></i>
                    {{ __('Change Password') }}
                </div>
                <div class="card-body">
                    <form action="{{ url('/password') }}" method="POST" id="form-update-password">

    
                        @include('includes.form_group_input', [
                            'label' => __("Current Password"),
                            'name' => 'old_password',
                            'type' => 'password',
                            'icon' => 'fa fa-key',
                            'dataValidation' => 'required'
                        ])
        
                        @include('includes.form_group_input', [
                            'label' => __('Password'),
                            'name' => 'password',
                            'type' => 'password',
                            'icon' => 'fa fa-key',
                            'dataValidation' => 'required length',
                            'dataValidationLength' => 'min8',
                        ])
        
                        @include('includes.form_group_input', [
                            'label' => __('Confirm Password'),
                            'name' => 'password_confirmation',
                            'type' => 'password',
                            'icon' => 'fa fa-key',
                            'dataValidation' => 'required confirmation',
                            'dataValidationConfirm' => 'password'
                        ])
        
                        <button class="btn btn-dark" type="submit">
                            <i class="fa fa-save"></i>
                            {{ __("Update Password") }}
                        </button>
                    </form>  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
$(document).ready(function(){
    $('#form-update-password').toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: "{{ __('UPDATED') }}",
                text: "{{ __('Your password is changed. Please login again.') }}",
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ url('/login') }}');
                }
            });
        }
    });
});
</script>
@endpush