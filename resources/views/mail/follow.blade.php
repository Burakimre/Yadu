@component('mail::message')

# {{$ownerName}}
    
@component('mail::button', ['url' => URL::to('/') . '/profile/' . $ownerId . '/accept', 'color' => 'success'])
{{$acceptButtonText}}
@endcomponent

@component('mail::button', ['url' => URL::to('/') . '/profile/' . $ownerId . '/decline', 'color' => 'error'])
{{$declineButtonText}}
@endcomponent

@endcomponent
