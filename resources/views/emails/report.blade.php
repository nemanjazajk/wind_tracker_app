@component('mail::message')

   
# Obaveštenje o stanju balona i brzini u proteklih 24h

- Prva tabela predstavlja stanje balona i vreme kada se to stanje promenilo
- Druga tabela prikazuje prosečnu brzinu za svakih sat vremena, proteklih 24h
@component('mail::table')
| Stanje balona       | Vreme         | 
| :-------------: |:-------------:| 
@foreach ($states as $foo)
| {{ $foo['currentState'] }} | {{ date_format($foo['created_at'], 'Y-m-d H:i:s') }} |
@endforeach
@endcomponent

@component('mail::table')
| brzina km/h      | Vreme         | 
| :-------------: |:-------------:| 
@foreach ($speed as $key => $content)
 <?php $contentb = $date[$key] ?>
| {{ number_format($content,1) }} | {{ $contentb }} |
@endforeach
@endcomponent

@component('mail::button', ['url'=>'https://weather.prolight.co.rs/'])
    Posetite sajt
@endcomponent
{{ config('app.name') }}
@endcomponent
