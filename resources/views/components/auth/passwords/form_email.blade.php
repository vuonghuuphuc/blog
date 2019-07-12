@php ($id = htmlId())
<form id="{{ $id }}" method="POST" action="{{ route('password.email') }}">
    
    @include('includes.form_group_input', [
        'label' => __('E-Mail Address'),
        'name' => 'email',
        'icon' => 'fa fa-envelope',
        'dataValidation' => 'required email'
    ])


    <button type="submit" class="btn btn-primary">
        <i class="fa fa-paper-plane"></i>
        {{ __('Send Password Reset Link') }}
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
                text: '{{ __("We have e-mailed your password reset link!") }}',
                type: 'success',
            }).then((result) => {
                if (result.value) {
                    redirect('{{ route("login") }}');
                }
            });
        }
    });
});
</script>

@endpush