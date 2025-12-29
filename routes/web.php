<?php
use Illuminate\Support\Facades\Route;

use App\Models\Room;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Player;
use Illuminate\Http\Request;

// Mostra il form
Route::get('/join', function () {

    return view('join');
});

// Mostra la pagina di join
Route::post('/join', function (Request $request) {
    $room = Room::where('code', $request->code)->first();

    if (!$room) {
        return "Stanza non trovata!";
    }

    $playerCount = Player::where('room_id', $room->id)->count();
    if ($playerCount >= $room->max_players) {
        return "La stanza è piena!";
    }

    // Controlla quanti giocatori ci sono già
    $existingPlayers = Player::where('room_id', $room->id)->get();

    // Definiamo i ruoli massimi disponibili
    $maxRoles = [
    'Lupo' => $room->max_lupi,
    'Veggente' => $room->max_veggenti,
    'Meretrice' => $room->max_meretrici,
    'Contadino' => $room->max_contadini,
];


    // Conta quanti giocatori hanno già ogni ruolo
    $roleCounts = [];
    foreach ($existingPlayers as $player) {
        $roleCounts[$player->role] = ($roleCounts[$player->role] ?? 0) + 1;
    }

    // Calcola ruoli ancora disponibili
    $availableRoles = [];
    foreach ($maxRoles as $role => $max) {
        $count = $roleCounts[$role] ?? 0;
        if ($count < $max) {
            $availableRoles[] = $role;
        }
    }

    if (empty($availableRoles)) {
        return "Tutti i ruoli disponibili sono stati assegnati!";
    }

    // Assegna un ruolo casuale tra quelli disponibili
    $role = $availableRoles[array_rand($availableRoles)];

    $player = Player::create([
        'room_id' => $room->id,
        'name' => $request->name,
        'role' => $role
    ]);
    return "Benvenuto {$player->name}! Il tuo ruolo è: {$player->role}";
});

// Mostra la pagina del narratore
Route::get('/room/{code}', function ($code) {
    $room = Room::where('code', $code)->first();

    if (!$room) {
        return "Stanza non trovata!";
    }
    return view('room', ['room' => $room]);
});

// Questa deve restituire il JSON per Axios
Route::get('/room/{code}/players', function ($code) {
    $room = \App\Models\Room::where('code', $code)->first();
    if (!$room) return response()->json([], 404);

    $players = \App\Models\Player::where('room_id', $room->id)->get();
    return response()->json($players);
});


// Creazione stanza
Route::get('/create-room', function () {
    return view('create-room');
});

Route::post('/create-room', function (Illuminate\Http\Request $request) {
    $totalRoles = $request->max_lupi + $request->max_veggenti + $request->max_meretrici + $request->max_contadini;

    if ($totalRoles > $request->max_players) {
        return response("Errore: i ruoli superano il numero massimo di giocatori", 400);
    }

    $room = \App\Models\Room::create([
        'code' => strtoupper(Str::random(6)),
        'max_players' => $request->max_players,
        'max_lupi' => $request->max_lupi,
        'max_veggenti' => $request->max_veggenti,
        'max_meretrici' => $request->max_meretrici,
        'max_contadini' => $request->max_contadini,
    ]);

    return $room->code;
});
