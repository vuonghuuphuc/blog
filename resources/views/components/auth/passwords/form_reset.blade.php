@php ($id = htmlId())
<form id="{{ $id }}" method="POST" action="{{ route('password.update') }}">
    
    <input type="hidden" name="token" value="{{ $token }}">

    @include('includes.form_group_input', [
        'label' => __('E-Mail Address'),
        'type' => 'email',
        'icon' => 'fa fa-envelope',
        'name' => 'email',
        'dataValidation' => 'required',
        'value' => $email,
        'readonly' => true
    ])

    @include('includes.form_group_input', [
        'label' => __('Password'),
        'name' => 'password',
        'type' => 'password',
        'icon' => 'fa fa-key',
        'dataValidation' => 'required'
    ])

    @include('includes.form_group_input', [
        'label' => __('Confirm Password'),
        'name' => 'password_confirmation',
        'type' => 'password',
        'icon' => 'fa fa-key',
        'dataValidation' => 'required confirmation',
        'dataValidationConfirm' => 'password'
    ])


    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i>
        {{ __('Reset Password') }}
    </button>
</form>

@push('scripts')
<script>
$(document).ready(function(){
    var form = $('#{{ $id }}');
    form.toAjaxAndValidateForm({
        success: function(){
            //Login success
            Swal.fire({
                title: '{{ __("Success") }}',
                text: '{{ __("Password is updated.") }}',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    reload();
                }
            });
        }
    });
});
</script>
@endpush