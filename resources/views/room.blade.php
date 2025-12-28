<h1>Stanza: {{ $room->code }}</h1>

<h2>Giocatori nella stanza:</h2>
<ul>
    @foreach($players as $player)
        <li>{{ $player->name }} - {{ $player->role }}</li>
    @endforeach
</ul>
