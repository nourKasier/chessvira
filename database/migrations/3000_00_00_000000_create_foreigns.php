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
        Schema::table('chess_matches', function (Blueprint $table) {
            $table->foreign('white_player_id')
                ->references('id')->on('users');
            $table->foreign('black_player_id')
                ->references('id')->on('users');
        });

        Schema::table('lobbies', function (Blueprint $table) {
            $table->foreign('player1_id')
                ->references('id')->on('users');
            $table->foreign('player2_id')
                ->references('id')->on('users');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('match_id')
                ->references('id')->on('chess_matches');
        });

        Schema::table('moves', function (Blueprint $table) {
            $table->foreign('match_id')
                ->references('id')->on('chess_matches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chess_matches', function (Blueprint $table) {
            $table->dropForeign('chess_matches_white_player_id_foreign');
            $table->dropIndex('chess_matches_white_player_id_foreign');

            $table->dropForeign('chess_matches_black_player_id_foreign');
            $table->dropIndex('chess_matches_black_player_id_foreign');
        });

        Schema::table('lobbies', function (Blueprint $table) {
            $table->dropForeign('lobbies_player1_id_foreign');
            $table->dropIndex('lobbies_player1_id_foreign');

            $table->dropForeign('lobbies_player2_id_foreign');
            $table->dropIndex('lobbies_player2_id_foreign');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_user_id_foreign');
            $table->dropIndex('messages_user_id_foreign');

            $table->dropForeign('messages_match_id_foreign');
            $table->dropIndex('messages_match_id_foreign');
        });

        Schema::table('moves', function (Blueprint $table) {
            $table->dropForeign('moves_match_id_foreign');
            $table->dropIndex('moves_match_id_foreign');
        });
    }
};
