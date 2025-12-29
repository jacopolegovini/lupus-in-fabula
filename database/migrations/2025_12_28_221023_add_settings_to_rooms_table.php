<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('max_players')->default(8);
            $table->integer('max_lupi')->default(2);
            $table->integer('max_veggenti')->default(1);
            $table->integer('max_meretrici')->default(1);
            $table->integer('max_contadini')->default(4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
    $table->dropColumn([
        'max_players',
        'max_lupi',
        'max_veggenti',
        'max_meretrici',
        'max_contadini',
    ]);
});

    }
};