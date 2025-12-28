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

Route::get('/join', function () {
    return view('join');
});

Route::post('/join', function (Illuminate\Http\Request $request) {
    $room = Room::where('code', $request->code)->first();

    if (!$room) {
        return "Stanza non trovata!";
    }

    $roles = ['Contadino', 'Lupo', 'Veggente'];
    $role = $roles[array_rand($roles)];

    $player = Player::create([
        'room_id' => $room->id,
        'name' => $request->name,
        'role' => $role
    ]);

    return "Benvenuto {$player->name}! Il tuo ruolo è: {$player->role}";
});