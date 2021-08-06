@component('mail::message')
# Obaveštenje

Zbog velike brzine vetra dolazi do spuštanja balona

@component('mail::button', ['url'=>'https://weather.prolight.co.rs/'])
    Posetite sajt
@endcomponent

{{ config('app.name') }}
@endcomponent
