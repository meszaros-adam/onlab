@extends('layouts.layout')

@section('content')
<ul> 
    @foreach($events as $event)
        <li> <a href= 'events/{{$event->id}}'>
            <h2>Esemény: {{$event->name}}</h2>
            <div>Leírás: {{$event->description}}</div>
        </li>
    @endforeach
</ul>
@endsection