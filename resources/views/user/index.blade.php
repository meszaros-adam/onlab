@extends('layouts.layout')

@section('content')
<ul class="user"> 
    @foreach($users as $user)
        <a href= 'users/{{$user->id}}'>
            <li>
                <h1>Email cím: {{$user->email}}</h1>
                <div>Felhasználó neve: {{$user->name}}</div>
            </li>
        </a>
    @endforeach
</ul>
@endsection