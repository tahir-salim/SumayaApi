@component('mail::message')

# Welcome,

@component('mail::panel')
Your 4-digit Verification Code is <b>{{$token}}</b>.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
