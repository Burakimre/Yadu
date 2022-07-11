@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer', ['url' => config('app.url')])

        @endcomponent
    @endslot
@endcomponent
