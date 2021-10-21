@extends('layouts.layout')

@section('content')
                <h1 class="body-title">Aktív regisztrációim:</h1>               
                <ul class= "registration"> 
                    @foreach($registrations as $registration)
                    <a href= 'registrations/{{$registration->id}}'>
                            <li> 
                            <h2>Esemény: {{$registration->event->name}}</h2>
                            <div>Esemény időpontja: {{$registration->event->date}}</div>
                            <div>Felnőttek száma: {{$registration->adult_headcount}}</div>
                            <div>Gyermekek száma: {{$registration->child_headcount}}</div>
                            </li>
                    </a>
                    @endforeach
                </ul>
@endsection
