@extends('layouts.layout')

@section('content')
<div class="registration-show"> 
    <h1> Regisztrációhoz tartozó esemény: {{$registration->event->name}}</h1>
    <div> Esemény leírása: {{$registration->event->description}} </div>
    <div> Esemény helyszíne: {{$registration->event->location}} </div>
    <div> Regisztrációhoz tartozó felhasználó: {{$registration->user->name}} </div>
    <div> Regisztrált felnőttek száma: {{$registration->adult_headcount}} fő </div>
    <div> Regisztrált gyermekek száma: {{$registration->child_headcount}} fő</div>
</div>
<ul class="button-row">
    <li>
        <form action="/registrations/{{$registration->id}}/edit">
            <input class="button" type="submit" value="Szerkesztés" />
        </form>
    </li>
    <li>
        <form method="post" action="/registrations/{{$registration->id}}"> 
            @csrf
            @method('DELETE')
            <button class="button" type="submit">Törlés</button>
        </form>
    </li>
</ul>
@endsection

