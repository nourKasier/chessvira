@extends('layouts.app', ['page' => __('Start'), 'pageSlug' => 'show'])

@section('content')

<h1>Start Match</h1>

@if ($match->black_player_id)
    <p>Waiting for another player to join...</p>
@else
    <form action="{{ route('match.join', ['id' => $match->id]) }}" method="post">
        @csrf
        <button type="submit">Start Match</button>
    </form>
@endif

@endsection
