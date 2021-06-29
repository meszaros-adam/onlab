@extends('layouts.layout')

@section('content')
<form method="post" action="/registrations/{{$registration->id}}">
    @csrf
    @method('PUT')

    <h1> Regisztráció módosítása {{$registration->event->name}}  eseménynél</h1>

  <div class="form">
    <label for="aduld_headcount">Hány felnőttel érkezik?</label><br>
    <input type="number" id="headcount" name="adult_headcount" value="{{$registration->adult_headcount}}"><br>
    <label for="child_headcount">Hány gyermekkel érkezik?</label><br>
    <input type="number" id="headcount" name="child_headcount" value="{{$registration->child_headcount}}"><br>
  </div>

  <input class="button" type="submit">

</form>
@endsection

