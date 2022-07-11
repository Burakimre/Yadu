@component('mail::message')
#{{$title}}

{{$salutation}} {{$userName}}

{{$body}}

###{{$infoTitle}}
@component('mail::panel',['url'=>''])
{{$eventName}}

{{$eventDate}}

{{$ownerName}}

{{$numberOfPeople}}

{{$description}}
@endcomponent

{{$closing}}
@endcomponent