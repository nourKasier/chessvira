@extends('layouts.app', ['page' => __('Contact Message'), 'pageSlug' => 'contactMessage'])

@section('content')
<div class="message">
    <p>Name: {{ $message->name }}</p>
    <p>Email: {{ $message->email }}</p>
    <p>Subject: {{ $message->subject }}</p>
    <p>Message: {{ $message->message }}</p>
</div>
@endsection