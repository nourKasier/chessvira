@extends('layouts.app', ['page' => __('Chess Game'), 'pageSlug' => 'show'])

@section('content')

<style>
    #timer {
        font-size: 24px;
        /* text-align: center; */
        /* margin-top: 10px; */
    }
    #opponent-timer {
        font-size: 24px;
        /* text-align: center; */
        /* margin-top: 10px; */
    }
</style>
<!-- <input type="hidden" id="playerId" value="{{ Auth::id() }}"> -->
<label style="font-weight: bold;">Opponent's Time:</label>
<div id="opponent-timer"></div>
<div id="chess-board" data-user-color="{{ session('userColor') }}"></div>
<div id="myBoard" style="width: 400px"></div>
<label style="font-weight: bold;">Your Time:</label>
<div id="timer"></div>
<label style="font-weight: bold;">Status:</label>
<div id="status"></div>
<label style="font-weight: bold;">FEN:</label>
<div id="fen"></div>
<label style="font-weight: bold;">PGN:</label>
<div id="pgn"></div>
<!-- <button onclick="startNewGame()">New Game</button> -->

<h1 style="margin-top:5px;">Match Details</h1>
<p>Match ID: {{ $match->id }}</p>
<p>White Player: {{ $match->white_player_id }}</p>
<p>Black Player: {{ $match->black_player_id }}</p>
<!-- Add more details as needed -->

@if (session('joined'))
<p>The second player has joined the match.</p>
@endif

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/chessboard-1.0.0.min.css') }}">
@endpush

@push('scripts')
<!-- <script type="module" src="{{ asset('js/appEcho.js') }}" defer></script> -->
<!-- <script src="../../node_modules/laravel-echo"></script> -->
<!-- <script src="{{ asset('resources/assets/js/app.js') }}"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="{{ asset('js/chessboard-1.0.0.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.min.js" integrity="sha512-xRllwz2gdZciIB+AkEbeq+gVhX8VB8XsfqeFbUh+SzHlN96dEduwtTuVuc2u9EROlmW9+yhRlxjif66ORpsgVA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="{{ asset('js/play-functions.js') }}"></script> -->
<!-- <script src="{{ mix('js/app.js') }}"></script> -->
@vite('resources/js/bootstrap.js')
@vite('resources/js/app.js')
@vite('resources/js/play-functions.js')
<!-- @vite('resources/js/timer-functions.js') -->

<!-- <script>
    Echo.channel('home').listen('NewEvent', (e) => {
        console.log(e.msg);
    })
</script> -->
@endpush
