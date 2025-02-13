@component('mail::message')

# Dear {{$name}},

The body of your message.

@component('mail::panel')
Welcome to Mindfulness. You have successfully created an account.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
