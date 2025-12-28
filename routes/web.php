<?php
use Illuminate\Support\Facades\Route;

use App\Models\Room;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/create-room', function () {
    $room = Room::create([
        'code' => strtoupper(Str::random(6))
    ]);

    return "Stanza creata! Codice: " . $room->code;
});

use App\Models\Player;
use Illuminate\Http\Request;

Route::post('/join', function (Request $request) {
    $room = Room::where('code', $request->code)->first();

    if (!$room) {
        return "Stanza non trovata!";
    }

    // Controlla quanti giocatori ci sono già
    $existingPlayers = Player::where('room_id', $room->id)->get();

    // Definiamo i ruoli massimi disponibili
    $maxRoles = ['Lupo' => 1, 'Veggente' => 1, 'Contadino' => 10];

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
