@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Users'),
            'href' => adminUrl('/users')
        ]
    ],
    'label' => __('Create New User')
])

<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7">
                <form id="form-create-user" action="{{ adminUrl('users') }}" method="POST">
                    <div class="row">
                        <div class="col-6">
                            @include('includes.form_group_input', [
                                'label' => __('First Name'),
                                'name' => 'first_name',
                                'dataValidation' => 'required'
                            ])
                        </div>
                        <div class="col-6">
                            @include('includes.form_group_input', [
                                'label' => __('Last Name'),
                                'name' => 'last_name',
                                'dataValidation' => 'required'
                            ])
                        </div>
                    </div>
                    @include('includes.form_group_input', [
                        'label' => __('E-Mail Address'),
                        'name' => 'email',
                        'icon' => 'fa fa-envelope',
                        'dataValidation' => 'required email'
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
                                <option value="writer">writer</option>
                                <option selected value="member">member</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        @include('includes.checkbox', [
                            'label' => __('Banned'),
                            'name' => 'banned',
                        ])
                    </div>

                    <button class="btn btn-dark" type="submit">
                        <i class="fa fa-plus"></i>
                        Create New User
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
    var form = $('#form-create-user');

    form.toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: '{{ __("CREATED") }}',
                text: '{{ __("New user is created") }}',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ adminUrl('/users') }}');
                }
            });
        }
    });
})
</script>

@endpush
