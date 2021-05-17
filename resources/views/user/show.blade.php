@extends('layouts.layout')

@section('content')
<h2>Email cím: {{$user->email}}</h2>
<div>Felhasználó neve: {{$user->name}}</div>
<div>Regisztráció időpontja: {{$user->name}}</div>
<div>
<form action="/users/{{$user->id}}/registrations">
    <input type="submit" value="Felhasználó regisztrációi" />
</form>
<form method="post" action="/users/{{$user->id}}"> 
    @csrf
    @method('DELETE')
    <button type="submit">Felhasználó törlése</button>
</form>
</div>
@endsection