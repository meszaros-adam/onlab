@extends('layouts.layout')

@section('content')
                <h1>Aktív regisztrációim:</h1>               
                <ul class= "registration"> 
                    @foreach($registrations as $registration)
                        <li> 
                            <a href= 'registrations/{{$registration->id}}'>
                            <h2>Esemény: {{$registration->event->name}}</h2>
                            <div>Esemény időpontja: {{$registration->event->date}}</div>
                            <div>Felnőttek száma: {{$registration->adult_headcount}}</div>
                            <div>Gyermekek száma: {{$registration->child_headcount}}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
@endsection
