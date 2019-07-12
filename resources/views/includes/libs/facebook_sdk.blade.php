@push('after_open_body')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3&appId={{ env('FACEBOOK_APP_ID') }}&autoLogAppEvents=1">
</script>
@endpush


