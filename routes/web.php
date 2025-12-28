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
