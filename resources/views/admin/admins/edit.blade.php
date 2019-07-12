@extends('layouts.admin')

@section('content')

@include('includes.breadcrumb', [
    'urls' => [
        [
            'label' => __('Admins'),
            'href' => adminUrl('/admins')
        ]
    ],
    'label' => __('Edit Admin')
])

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <form id="form-create-admin" action="{{ adminUrl('admins/' . $admin->id) }}" method="POST">
                    @method('PUT')

                    @include('includes.form_group_input', [
                        'label' => __('Username'),
                        'icon' => 'fa fa-envelope',
                        'value' => $admin->username,
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
                                <option {{ $admin->type == 'admin' ? 'selected' : '' }} value="admin">admin</option>
                                <option {{ $admin->type == 'publisher' ? 'selected' : '' }} value="publisher">publisher</option>
                                <option {{ $admin->type == 'writer' ? 'selected' : '' }} value="writer">writer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        @include('includes.checkbox', [
                            'label' => __('Banned'),
                            'name' => 'banned',
                            'checked' => !!$admin->is_banned
                        ])
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-save"></i>
                        Save Changes
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
                title: '{{ __("UPDATED") }}',
                text: '{{ __("The admin is updated") }}',
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
