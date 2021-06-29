@extends('layouts.layout')

@section('content')
<form method="post" action="/events">
    @csrf

  <h1> Esemény létrehozása: </h1>   

  <div class="form">
    <label for="name">Esemény neve:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="date">Időpontja:</label><br>
    <input type="datetime-local" id="date" name="date"><br>

    <label for="description">Leírás:</label><br>
    <input type="text" id="description" name="description"><br>

    <label for="headcount">Létszám:</label><br>
    <input type="number" id="headcount" name="headcount"><br>

    <label for="location">Helyszín:</label><br>
    <input type="text" id="location" name="location"><br>
  </div>

  <input class="button" type="submit" >

</form>
@endsection