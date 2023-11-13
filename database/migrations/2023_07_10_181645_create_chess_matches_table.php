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
        Schema::create('chess_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('white_player_id')->nullable();
            $table->unsignedBigInteger('black_player_id')->nullable();
            $table->string('pgn')->nullable();
            $table->timestamp('initial_time')->nullable();
            $table->integer('player1_time')->nullable();
            $table->integer('player2_time')->nullable();
            $table->timestamp('player1_disconnection_time')->nullable();
            $table->timestamp('player2_disconnection_time')->nullable();
            $table->timestamp('player1_last_move_timestamp')->nullable();
            $table->timestamp('player2_last_move_timestamp')->nullable();
            $table->boolean('player1_ready')->default(false);
            $table->boolean('player2_ready')->default(false);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('white_player_id')->references('id')->on('users');
            // $table->foreign('black_player_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chess_matches');
    }
};
