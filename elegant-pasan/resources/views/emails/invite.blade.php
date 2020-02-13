@component('mail::message')
# Friend Invitation From {{ $name }}

#To connect, please click below button and accept the invitation.

@component('mail::button', ['url' => $url])
Accept
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
