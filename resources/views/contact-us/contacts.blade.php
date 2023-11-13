@extends('layouts.app', ['page' => __('Contact Messages'), 'pageSlug' => 'contactMessages'])

@section('content')

<table class="table table-responsive fixed-width-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Sent At</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
        <tr>
            <td style="width: 14%;" class="truncate">{{ $message->id }}{{ $message->name }}</td>
            <td style="width: 18%;" class="truncate">{{ $message->email }}</td>
            <td style="width: 18%;" class="truncate">{{ $message->subject }}</td>
            <td style="width: 26%;" class="truncate">{{ $message->message }}</td>
            <td style="width: 12%;" class="truncate">{{ $message->created_at }}</td>
            <td style="width: 12%;" class="td-actions text-right truncate">
                <a href="{{ route('contact.show', $message->id) }}" rel="tooltip" class="btn btn-info btn-link btn-icon btn-sm">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <form action="{{ route('contact.destroy', $message->id) }}" method="POST" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-link btn-icon btn-sm" onclick="return confirm('Are you sure you want to delete this contact?')">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination-container">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($messages->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $messages->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($messages as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $messages->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($messages->hasMorePages())
            <li><a href="{{ $messages->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
</div>

@endsection

@push('styles')
<style>
    .truncate {
        max-width: 200px;
        /* Adjust the value as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }

    .table {
        width: 100%;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination {
        display: flex;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a {
        display: inline-block;
        padding: 8px 12px;
        background-color: #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        background-color: #333;
        color: #fff;
    }

    .pagination li.active a {
        background-color: #333;
        color: #fff;
    }

    .pagination li.disabled span {
        display: inline-block;
        padding: 8px 12px;
        background-color: #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        background-color: #333;
        color: #fff;

        pointer-events: none;
        opacity: 0.6;
    }
</style>
@endpush