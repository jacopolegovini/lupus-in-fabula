<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'max_players',
        'max_lupi',
        'max_veggenti',
        'max_contadini',
    ];}
