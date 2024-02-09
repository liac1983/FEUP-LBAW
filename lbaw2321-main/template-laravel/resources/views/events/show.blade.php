<!-- resources/views/events/show.blade.php -->

@extends('layouts.app')

<!-- No cabeçalho do seu layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


@section('content')
    <div class="event-details-container">
        <div class="event-box">
            <div class="event-photo">
                <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
            </div>
            <div class="event-details">
                <h2>{{ $event->eventname }}</h2>
                <p><strong>Start Date:</strong> {{ $event->startdatetime }}</p>
                <p><strong>End Date:</strong> {{ $event->enddatetime }}</p>
                <p><strong>Registration End Time:</strong> {{ $event->registrationendtime }}</p>
                <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                <p><strong>Location:</strong> {{ $event->local }}</p>
                <p><strong>Status:</strong> {{ $event->status }}</p>
                <p><strong>Description:</strong> {{ $event->description }}</p>
            </div>
        </div>

        <div class="comments-container">
            <h3 style="color:#f0ba4b;">Comments</h3>
            
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    <div class="comment-box">
                        <p>{{ $comment->owner->name }} : {{ $comment->content }}</p>
                        @if(auth()->id() == $comment->owner_id)
                            <form method="post" action="{{ route('comment.destroy', ['commentId' => $comment->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="delete-comment-btn">
                                    <i class="fas fa-trash-alt"></i> <!-- Ícone do caixote do lixo -->
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No comments found.</p>
            @endif

            <!-- Formulário para adicionar um novo comentário -->
            <form method="post" action="{{ route('comment.store', ['eventId' => $event->id]) }}">
                @csrf
                <textarea name="content" style="border-radius: 15px;" placeholder="Add a comment..." required></textarea>
                <button type="submit" style="border-radius: 20px; background-color:#f0ba4b;border: 2px solid #f0ba4b; ">Add Comment</button>
            </form>
        </div>
    </div>
@endsection
