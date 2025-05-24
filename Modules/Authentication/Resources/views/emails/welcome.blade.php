@component('mail::message')
{!!  setting('other','welcome_message') !!}

{{__('apps::frontend.emails.thanks')}},<br>{{ config('app.name') }}
@endcomponent
