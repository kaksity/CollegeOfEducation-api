@component('mail::message')
# New Student Registeration

Hi {{ $content['personalInformation']->surname }} {{ $content['personalInformation']->other_names }},

You have been registered as a returning student on the {{ config('app.name') }} portal,<br>
You can go ahead to change your password and also complete your profile.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
