@php ($id = htmlId())
<form id="{{ $id }}" method="POST" action="{{ route('register') }}">

    <div class="row">
        <div class="col-md-6">
            @include('includes.form_group_input', [
                'label' => __('First Name'),
                'name' => 'first_name',
                'dataValidation' => 'required',
            ])
        </div>
        <div class="col-md-6">
            @include('includes.form_group_input', [
                'label' => __('Last Name'),
                'name' => 'last_name',
                'dataValidation' => 'required',
            ])    
        </div>
    </div>

    @include('includes.form_group_input', [
        'label' => __('E-Mail Address'),
        'name' => 'email',
        'icon' => 'fa fa-envelope',
        'dataValidation' => 'required email',
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
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-user-plus"></i>
            {{ __('Register') }}
        </button>
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