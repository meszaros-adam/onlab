<h1> Regisztrációhoz tartozó esemény: {{$registration->event->name}}</h1>
<div> Esemény leírása: {{$registration->event->description}} </div>
<div> Esemény helyszíne: {{$registration->event->location}} </div>
<div> Regisztrációhoz tartozó felhasználó: {{$registration->user->name}} </div>
<div> Regisztrált felnőttek száma: {{$registration->adult_headcount}} fő </div>
<div> Regisztrált gyermekek száma: {{$registration->child_headcount}} fő</div>
<div>  
    <form action="/registrations/{{$registration->id}}/edit">
        <input type="submit" value="Szerkesztés" />
    </form>  
</div>
<div>
<form method="post" action="/registrations/{{$registration->id}}"> 
    @csrf
    @method('DELETE')
    <button type="submit">Törlés</button>
</form>
</div>


