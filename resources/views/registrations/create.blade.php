@extends('layouts.layout')

@section('content')
<form method="post" action="/registrations/{{$event->id}}">
    @csrf

  <h1> Regisztráció {{$event->name}}  eseményre</h1>    

  <div class="form">
    <label for="adult_headcount">Hány felnőttel érkezik?</label><br>
    <input type="number" id="headcount" name="adult_headcount" value=0><br>
    <label for="child_headcount">Hány gyermekkel érkezik?</label><br>
    <input type="number" id="headcount" name="child_headcount" value =0><br>
  </div>
  
  <input class="button" type="submit">

</form>
@endsection