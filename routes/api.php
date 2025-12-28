<?php

use App\Models\Room;
use App\Models\Player;
use Illuminate\Support\Facades\Route;

Route::get('/room/{code}/players', function ($code) {
    $room = Room::where('code', $code)->first();
    if (!$room) return response()->json([]);
    $players = Player::where('room_id', $room->id)->get();
    return response()->json($players);
});
