@extends('layouts.layout')

@section('content')
<h1 class="body-title">Aktív események:</h1>
<ul class="event">
    @if(count($active_events)>0)
    @foreach($active_events as $event)
        <a href= 'events/{{$event->id}}'> 
            <li>                        
                <h1>Esemény: {{$event->name}}</h1>
                <div>Leírás: {{$event->description}}</div>
            </li>
        </a>
    @endforeach
    @else
        <h1>Jelenleg nincs kiírva esemény</h1>
    @endif
</ul>
<hr>
<h1 class="body-title">Korábbi események:</h1>
<ul class="event">
    @if(count($earlier_events)>0)
    @foreach($earlier_events as $event)
        <a href= 'events/{{$event->id}}'>
            <li>                        
                <h1>Esemény: {{$event->name}}</h1>
                <div>Leírás: {{$event->description}}</div>
            </li>
        </a>
    @endforeach
    @else
        <h1>Nem jeleníthető meg korábbi esemény</h1>
    @endif
</ul>
@endsection