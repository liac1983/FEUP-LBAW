<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|max:512',
            'event_id' => 'required|exists:events,id',
        ]);

        // Create and store the comment
        Comment::create([
            'content' => $request->input('content'),
            'owner_id' => auth()->user()->id, // Assuming users are authenticated
            'event_id' => $request->input('event_id'),
            'datetime' => now(),
        ]);

        // Redirect back to the event page after storing the comment
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
