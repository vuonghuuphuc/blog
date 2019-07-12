@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Admins'),
            'href' => adminUrl('/admins')
        ]
    ],
    'label' => __('Create New Admin')
])

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <form id="form-create-admin" action="{{ adminUrl('admins') }}" method="POST">

                    @include('includes.form_group_input', [
                        'label' => __('Username'),
                        'name' => 'username',
                        'icon' => 'fa fa-user',
                        'dataValidation' => 'required'
                    ])
                    @include('includes.form_group_input', [
                        'label' => __('Password'),
                        'name' => 'password',
                        'type' => 'password',
                        'icon' => 'fa fa-key',
                        'dataValidation' => 'required',
                    ])
                
                    @include('includes.form_group_input', [
                        'label' => __('Confirm Password'),
                        'name' => 'password_confirmation',
                        'type' => 'password',
                        'icon' => 'fa fa-key',
                        'dataValidation' => 'required confirmation',
                        'dataValidationConfirm' => 'password'
                    ])

                    <div class="form-group">
                        <label for="">{{ __('Type') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-flag"></i>
                                </div>
                            </div>
                            <select name="type" class="form-control">
                                <option value="admin">admin</option>
                                <option value="publisher">publisher</option>
                                <option selected value="writer">writer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        @include('includes.checkbox', [
                            'label' => __('Banned'),
                            'name' => 'banned',
                        ])
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-plus"></i>
                        Create New Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection



@push('scripts')

<script>
$(document).ready(function(){
    var form = $('#form-create-admin');

    form.toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: 'CREATED',
                text: 'New admin is created',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ adminUrl('/admins') }}');
                }
            });
        }
    });
})
</script>

@endpush
