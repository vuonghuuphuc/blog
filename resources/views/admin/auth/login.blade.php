@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-3 shadow-lg">
                <div class="card-header">{{ __('Admin Control Panel') }}</div>

                <div class="card-body ">
                    <form id="form-admin-login" action="{{ adminUrl('/login') }}" method="POST">
                        @include('includes.form_group_input', [
                            'label' => __('E-Mail  Address'),
                            'dataValidation' => 'required email',
                            'icon' => 'fa fa-user',
                            'name' => 'username'
                        ])
                        @include('includes.form_group_input', [
                            'label' => __('Password'),
                            'dataValidation' => 'required',
                            'icon' => 'fa fa-key',
                            'name' => 'password',
                            'type' => 'password'
                        ])
                        <button class="btn btn-dark" type="submit">
                            <i class="fa fa-sign-in-alt"></i>
                            Login
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
    var form = $('#form-admin-login');
    form.toAjaxAndValidateForm({
        success: function(){
            reload();
        }
    });
});
</script>
@endpush