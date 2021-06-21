@extends('layouts.layout')


@section('banner')
@can('create', 'App/Models/Event')
<div id="banner" class="container">
				<a href="events/create" class="button">Esemény létrehozása</a> 
</div>
@endcan
@endsection


@section('content')
<ul> 
    @foreach($events as $event)
        <li> 
            <a href= 'events/{{$event->id}}'>
            <h1>Esemény: {{$event->name}}</h1>
            <div>Leírás: {{$event->description}}</div>
            </a>
        </li>
    @endforeach
</ul>
@endsection