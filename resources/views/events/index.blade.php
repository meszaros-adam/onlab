@extends('layouts.layout')

@section('content')
<ul class="event"> 
    @foreach($filtered_events as $event)
        <li> 
            <a href= 'events/{{$event->id}}'>            
            <h1>Esemény: {{$event->name}}</h1>
            <div>Leírás: {{$event->description}}</div>
            </a>
        </li>
    @endforeach
</ul>
@endsection