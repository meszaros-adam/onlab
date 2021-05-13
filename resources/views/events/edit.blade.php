@extends('layouts.layout')

@section('content')
<form method="post" action="/events/{{$event->id}}">
    @csrf
    @method('PUT')

    <div>
    <label> Esemény szerkesztése: </label>
    </div>

<div>
  <label for="name">Esemény neve:</label><br>
  <input type="text" id="name" name="name" value="{{$event->name}}"><br>

  <label for="date">Időpontja:</label><br>
  <input type="datetime" id="date" name="date" value="{{$event->date}}"><br>

  <label for="description">Leírás:</label><br>
  <input type="text" id="description" name="description" value="{{$event->description}}"><br>

  <label for="headcount">Létszám:</label><br>
  <input type="number" id="headcount" name="headcount" value="{{$event->headcount}}"><br>

  <label for="location">Helyszín:</label><br>
  <input type="text" id="location" name="location" value="{{$event->location}}"><br>
</div>
<div>
<button type="submit">Mentés</button>
</div>
</form>
@endsection


