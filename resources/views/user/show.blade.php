@extends('layouts.layout')

@section('content')
<div class="user-show">
    <h2>Email cím: {{$user->email}}</h2>
    <div>Felhasználó neve: {{$user->name}}</div>
    <div>Regisztráció időpontja: {{$user->name}}</div>
</div>
<ul class="button-row">
    <li>
    <form action="/users/{{$user->id}}/registrations">
        <input class="button" type="submit" value="Felhasználó regisztrációi" />
    </form>
    </li>
    <li>
    <form method="post" action="/users/{{$user->id}}"> 
        @csrf
        @method('DELETE')
        <button class="button" type="submit">Felhasználó törlése</button>
    </form>
    </li>
<ul>
@endsection