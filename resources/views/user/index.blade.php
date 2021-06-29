@extends('layouts.layout')

@section('content')
<ul class="user"> 
    @foreach($users as $user)
        <li> 
            <a href= 'users/{{$user->id}}'>
            <h2>Email cím: {{$user->email}}</h2>
            <div>Felhasználó neve: {{$user->name}}</div>
            </a>
        </li>
    @endforeach
</ul>
@endsection