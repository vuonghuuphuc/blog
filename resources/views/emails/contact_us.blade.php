@component('mail::message')
# {{ __('Contact Us') }}
<strong>{{ __('E-Mail Address') }}</strong>: {{ $input['email'] }}
<br>
<strong>{{ __('Url') }}</strong>: {{ $input['url'] }}
<br>
<strong>{{ __('Message') }}</strong>: {{ $input['message'] }}
@endcomponent
