@extends('layouts.app', ['page' => __('Menu'), 'pageSlug' => 'show'])

@section('content')

<h1>Join Match</h1>

    <form id="startNewGameForm"  action="{{ route('match.start') }}"  method="get">
        @csrf
        <button type="submit" class="btn btn-primary">10 + 0 Rapid</button>
    </form>

@endsection
