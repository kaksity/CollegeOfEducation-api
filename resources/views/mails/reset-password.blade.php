@component('mail::message')
# Password reset code

Hi {{ $content['personalInformation']->surname }},

Please use this code to reset the password for your account.

Here is your code: **{{ $content['token'] }}**


Thanks,<br>
The {{ config('app.name') }} team
@endcomponent
