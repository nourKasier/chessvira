@extends('layouts.app', ['page' => __('Contact Us'), 'pageSlug' => 'contact'])

@section('content')

<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div style="cursor: auto;" class="form-group has-success">
            <input style="cursor: auto;color:#00f2c3;" type="text" value="{{ session('success') }}" class="form-control form-control-success" disabled />
        </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Your name" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Your email address" value="{{ old('email') }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}">
                @error('subject')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                @error('message')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" id="submitContact" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection