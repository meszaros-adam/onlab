<form method="post" action="/registrations/{{$event->id}}/{{Auth::user()->id}}">
    @csrf

    <div>
    <label> Regisztráció {{$event->name}}  eseményre</label>
    </div>

<div>
  <label for="adult_headcount">Hány felnőttel érkezik?</label><br>
  <input type="number" id="headcount" name="adult_headcount" value=0><br>
  <label for="child_headcount">Hány gyermekkel érkezik?</label><br>
  <input type="number" id="headcount" name="child_headcount" value =0><br>
</div>
<div>
<input type="submit">
</div>

</form>