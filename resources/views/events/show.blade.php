<h1> {{$event->name}} </h1>
<div> Leírás: {{$event->description}} </div>
<div> Létszám: {{$event->headcount}} fő </div>
<div> Szabad helyek: {{$event->free_places()}}</div>
<div> Időpont: {{$event->date}} </div>
<div> Helyszín: {{$event->location}} </div>
<div>  
    <form action="/registrations/create/{{$event->id}}">
        <input type="submit" value="Regisztráció" />
    </form>  
</div>
