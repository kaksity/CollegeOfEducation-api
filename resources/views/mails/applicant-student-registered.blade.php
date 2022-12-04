@component('mail::message')
# New Application Registration

Hi {{ $content['personalInformation']->surname }} {{ $content['personalInformation']->other_names }},

You have registered as an applicant on the {{ config('app.name') }} application portal,<br>
Kindly complete your application process.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
