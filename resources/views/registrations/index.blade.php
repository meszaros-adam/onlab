@extends('layouts.layout')

@section('content')
<h1>Az összes regisztráció: </h1>
<ul class="registration"> 
    @foreach($registrations as $registration)
        <a href= 'registrations/{{$registration->id}}'>
            <li> 
                <h2>Felhasználó: {{$registration->user->email}}</h2>
                <div>Esemény neve: {{$registration->event->name}}</div>
                <div>Felnőttek száma: {{$registration->adult_headcount}}</div>
                <div>Gyermekek száma: {{$registration->child_headcount}}</div>
            </li>
        </a>
    @endforeach
</ul>
@endsection