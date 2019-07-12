@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Users'),
            'href' => adminUrl('/users')
        ]
    ],
    'label' => __('Edit User')
])

<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-light">
                        <div class="mb-0">{{ __('Details') }}</div>        
                    </div>
                    <div class="card-body">
                        <form id="form-edit-user" action="{{ adminUrl('users/' . $user->id) }}" method="POST">
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    @include('includes.form_group_input', [
                                        'label' => __('First Name'),
                                        'name' => 'first_name',
                                        'dataValidation' => 'required',
                                        'value' => $user->first_name
                                    ])
                                </div>
                                <div class="col-6">
                                    @include('includes.form_group_input', [
                                        'label' => __('Last Name'),
                                        'name' => 'last_name',
                                        'dataValidation' => 'required',
                                        'value' => $user->last_name
                                    ])
                                </div>
                            </div>
                            @include('includes.form_group_input', [
                                'label' => __('E-Mail Address'),
                                'name' => 'email',
                                'icon' => 'fa fa-envelope',
                                'dataValidation' => 'required email',
                                'value' => $user->email,
                                'disabled' => true,
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
                                        <option {{ $user->type == 'admin' ? 'selected' : '' }} value="admin">admin</option>
                                        <option {{ $user->type == 'publisher' ? 'selected' : '' }} value="publisher">publisher</option>
                                        <option {{ $user->type == 'writer' ? 'selected' : '' }} value="writer">writer</option>
                                        <option {{ $user->type == 'member' ? 'selected' : '' }} value="member">member</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Social</label>
                                        <div class="form-control-plaintext">
                                            @if ($user->facebook_id)
                                            <i class="fab fa-facebook text-primary"></i> 
                                            @endif

                                            @if ($user->google_id)
                                            <i class="fab fa-google text-danger"></i> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Posts</label>
                                        <div class="form-control-plaintext">
                                            {{ $user->posts()->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">{{ __('Created') }}</label>
                                        <div class="form-control-plaintext">
                                            {{ $user->created_at->isoFormat('d MMM Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">{{ __('Verified') }}</label>
                                        <div class="form-control-plaintext">
                                            @if ($user->email_verified_at)
                                            {{ $user->email_verified_at->isoFormat('d MMM Y') }}    
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="form-group">
                                @include('includes.checkbox', [
                                    'label' => __('Banned'),
                                    'name' => 'banned',
                                    'checked' => !!$user->is_banned
                                ])
                            </div>
        
                            <button class="btn btn-dark" type="submit">
                                <i class="fa fa-save"></i>
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-5">
                <div class="card  shadow-sm">
                    <div class="card-header bg-dark text-light">
                        <div class="mb-0">{{ __('Change Password') }}</div>    
                    </div>
                    <div class="card-body">
                        <form id="form-change-password" action="{{ adminUrl('users/' . $user->id . '/password') }}" method="POST">
                            @method('PATCH')                    
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
</div>



@endsection



@push('scripts')

<script>
$(document).ready(function(){

    $('#form-edit-user').toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: '{{ __("UPDATED") }}',
                text: '{{ __("The user is updated") }}',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ adminUrl('/users') }}');
                }
            });
        }
    });

    $('#form-change-password').toAjaxAndValidateForm({
        success: function(){
            Swal.fire({
                title: '{{ __("UPDATED") }}',
                text: '{{ __("The password is updated") }}',
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
