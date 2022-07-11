@component('mail::message')
# {{__($headText)}}

{{$salutation . $name}}

{{$bodyText}}

{{__('mail.closing')}}
@endcomponent