@extends('layouts.layout')

@section('content')
<h1>Aktív események:</h1>
<ul class="event">
    @if(count($active_events)>0)
    @foreach($active_events as $event)
        <li> 
            <a href= 'events/{{$event->id}}'>            
            <h1>Esemény: {{$event->name}}</h1>
            <div>Leírás: {{$event->description}}</div>
            </a>
        </li>
    @endforeach
    @else
        <h1>Jelenleg nincs kiírva esemény</h1>
    @endif
</ul>
<hr>
<h1>Korábbi események:</h1>
<ul class="event">
    @foreach($earlier_events as $event)
        <li> 
            <a href= 'events/{{$event->id}}'>            
            <h1>Esemény: {{$event->name}}</h1>
            <div>Leírás: {{$event->description}}</div>
            </a>
        </li>
    @endforeach
</ul>
@endsection