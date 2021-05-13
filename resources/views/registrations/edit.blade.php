@extends('layouts.layout')

@section('content')
<form method="post" action="/registrations/{{$registration->id}}">
    @csrf
    @method('PUT')

    <div>
    <label> Regisztráció módosítása {{$registration->event->name}}  eseménynél</label>
    </div>

<div>
  <label for="aduld_headcount">Hány felnőttel érkezik?</label><br>
  <input type="number" id="headcount" name="adult_headcount" value="{{$registration->adult_headcount}}"><br>

  <label for="child_headcount">Hány gyermekkel érkezik?</label><br>
  <input type="number" id="headcount" name="child_headcount" value="{{$registration->child_headcount}}"><br>

</div>
<div>
<button type="submit">Módosítás</button>
</div>
</form>
@endsection

