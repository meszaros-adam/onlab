@extends('layouts.layout')

@section('content')
<div class="event-show">
    <h1> {{$event->name}} </h1>
    <div> Leírás: {{$event->description}} </div>
    <div> Létszám: {{$event->headcount}} fő </div>
    <div> Szabad helyek: {{$event->free_places()}}</div>
    <div> Időpont: {{$event->date}} </div>
    <div> Helyszín: {{$event->location}} </div>
<div>
    
</div>
    <form action="/registrations/create/{{$event->id}}">
    <button class="button" type="submit">Regisztráció</button>
    </form> 
</div>
<div>
    @can('update', $event)
    <form action="/events/{{$event->id}}/edit">
        <button class="button" type="submit">Szerkesztés</button>
    </form>
    @endcan
</div>
<div>
    @can('delete', $event)
    <form method="post" action="/events/{{$event->id}}"> 
        @csrf
        @method('DELETE')
        <button class="button" type="submit">Törlés</button>
    </form>
    @endcan
</div>
@endsection
