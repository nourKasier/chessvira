@extends('layouts.app', ['page' => __('lobby'), 'pageSlug' => 'show'])

@section('content')

<h1>Lobby</h1>

@if ($waitingLobbies->isEmpty())
<p>No lobbies currently waiting. Create a new lobby and wait for another player to join.</p>
@else
<p>Waiting lobbies:</p>
<ul>
    @foreach ($waitingLobbies as $lobby)
    <li>
        Lobby ID: {{ $lobby->id }} |
        Player 1 ID: {{ $lobby->player1_id }} |
        Created at: {{ $lobby->created_at }}
    </li>
    @endforeach
</ul>
@endif

<!-- <form action="" method="POST">
    @csrf
    <button type="submit">Join Lobby</button>
</form> -->

@endsection

@push('scripts')
<script>
    // Check if the second player has joined the game
    function checkSecondPlayerJoined() {
        // Make an AJAX request to check if the second player joined
        // Replace the URL with the endpoint that checks the game status
        // You may need to customize the AJAX request based on your implementation
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: '/check-game-status',
            method: 'GET',
            success: function(response) {
                if (response.secondPlayerJoined) {
                    // Redirect to the game page
                    window.location.href = '/matches/' + response.matchId;
                } else {
                    // Check again after a delay
                    setTimeout(checkSecondPlayerJoined, 1000);
                }
            },
            error: function() {
                // Handle error case if needed
            }
        });
    }

    // Call the function to start checking for the second player
    checkSecondPlayerJoined();
</script>
@endpush
