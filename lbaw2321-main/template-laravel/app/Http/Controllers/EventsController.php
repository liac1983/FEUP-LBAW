<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitation;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Tag;
use App\Notifications\EventInvitationNotification;



class EventsController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->input('query');

        $events = Event::where('eventname', 'like', '%' . $query . '%')->get();

        return view('events.search', ['events' => $events, 'query' => $query]);
    }

    
    public function showEvents()
{
    $tags = Tag::all();

    $publicEvents = Event::where('ispublic', true)->get()->toArray();

    $userId = auth()->id();
    $privateEvents = Event::whereIn(
        'id',
        function ($query) use ($userId) {
            $query->select('event_id')
                ->from('eventinvitation')
                ->where('user_invited_id', $userId);
        }
    )->where('ispublic', false)->get()->toArray();

    $events = array_merge($publicEvents, $privateEvents);

    $wishlist = $this->checkWishlist();
    
    // Check attendance status for each event
    foreach ($events as &$event) {
        $event['inWishlist'] = in_array($event['id'], $wishlist);
        $event['isGoing'] = $this->checkAttendanceStatus($event['id'], $userId, 'Going');
    }

    return view('begin', ['events' => $events, 'wishlist' => $wishlist, 'tags' => $tags]);
}

private function checkAttendanceStatus($eventId, $userId, $participation)
{
    $attendance = DB::table('attendance')
        ->where('event_id', $eventId)
        ->where('user_id', $userId)
        ->where('participation', $participation)
        ->exists();

    return $attendance;
}



    public function createEvent(Request $request) {
        try {
    
            $request->validate([
                'eventname' => 'required|string|max:256',
                'startdatetime' => 'required|date',
                'enddatetime' => 'required|date|after:startDateTime',
                'registrationendtime' => 'required|date',
                'local' => 'required|string|max:256',
                'description' => 'required|string|max:512',
                'capacity' => 'required|integer|min:1',
                'isPublic' => 'boolean',
                'status' => 'in:Active,Suspended,OtherStatus',
                'tag_id' => 'nullable|exists:tags,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
    
            $ownerId = auth()->id();

        $eventData = $request->all();
        $eventData['owner_id'] = $ownerId;

        $eventData['isPublic'] = $request->has('isPublic') ? $request->input('isPublic') : true;
        $eventData['status'] = $request->input('status', 'Active');

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('event_photos', 'public');
            $eventData['photo'] = $photoPath;
        }

        $event = Event::create($eventData);

        // Fetch tags to pass to the view
        $tags = Tag::all();

        $events = Event::all();

        // Pass tags to the 'begin' view
        return view('begin', ['events' => $events, 'tags' => $tags]);

    } catch (\Exception $e) {
        Log::error('Error creating event: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Error creating event. Please try again.');
    }
    }


    public function showCreateForm() {
        $tags = Tag::all();
        return view('formsevent', ['tags' => $tags]);
    }


    public function show($id) {
        $event = Event::find($id);

        if (!$event) {

            abort(404);
        }

        $comments = Comment::where('event_id', $event->id)->get();

        return view('events.show', ['event' => $event, 'comments' => $comments]);
    }

    public function showMyEvents(){
        $ownerId = auth()->id();

        $myEvents = Event::where('owner_id', $ownerId)->get();

    return view('myevents', ['myEvents' => $myEvents]);
}


public function sendInvitation(Request $request, $eventId)
{
    $request->validate([
        'inviteeId' => 'required|exists:users,id',
    ]);

    $event = Event::find($eventId);
    $user = User::find($request->input('inviteeId'));

    $invitation = Invitation::createInvitation($event, $user);
    $user->notify(new EventInvitationNotification($invitation));


    // Redirect or perform any other actions
    return redirect()->route('event.show', ['id' => $eventId])->with('success', 'Invitation sent successfully!');
}



    public function showInviteForm($eventId)
    {
        $users = User::all();
        $event = Event::find($eventId);

        return view('form', ['users' => $users, 'event' => $event]);
    }

    public function showSentInvitations()
    {
        $userId = Auth::id();
        $sentInvitations = Invitation::where('user_host_id', $userId)->get();

        return view('sent_invitations', ['sentInvitations' => $sentInvitations]);
    }

    public function showReceivedInvitations()
    {
        $userId = Auth::id();
        $receivedInvitations = Invitation::where('user_invited_id', $userId)->get();

        return view('received_invitations', ['receivedInvitations' => $receivedInvitations]);
    }

    public function showEventsImGoing()
    {
        $userId = Auth::id();

        $goingEvents = DB::table('attendance')
            ->join('events', 'attendance.event_id', '=', 'events.id')
            ->where('attendance.user_id', '=', $userId)
            ->where('attendance.participation', '=', 'Going')
            ->select('events.*','attendance.participation')
            ->get();
        
        $notgoingEvents = DB::table('attendance')
            ->join('events', 'attendance.event_id', '=', 'events.id')
            ->where('attendance.user_id', '=', $userId)
            ->where('attendance.participation', '=', 'Not Going')
            ->select('events.*')
            ->get();

        $maybegoingEvents = DB::table('attendance')
            ->join('events', 'attendance.event_id', '=', 'events.id')
            ->where('attendance.user_id', '=', $userId)
            ->where('attendance.participation', '=', 'Maybe')
            ->select('events.*')
            ->get();

            
        return view('events.going', ['goingEvents' => $goingEvents, 'notgoingEvents' => $notgoingEvents, 'maybegoingEvents' => $maybegoingEvents]);
    }

public function toggleAttendance(Request $request, $eventId, $participation)
{
    $userId = auth()->id();

    // Update or create attendance record
    DB::table('attendance')->updateOrInsert(
        ['event_id' => $eventId, 'user_id' => $userId],
        ['participation' => $participation]
    );

    return redirect()->back()->with('success', 'Attendance status updated.');
}



    public function showWishlist()
    {
        $userId = Auth::id();
        
        $wishlist = DB::table('attendance')
            ->join('events', 'attendance.event_id', '=', 'events.id')
            ->where('attendance.user_id', '=', $userId)
            ->where('attendance.wishlist', '=', true)
            ->select('events.*')
            ->get();

        return view('events.wishlist', ['wishlist' => $wishlist]);
    }

    public function checkWishlist(){
    $userId = Auth::id();
    
    $wishlistEvents = DB::table('attendance')
        ->join('events', 'attendance.event_id', '=', 'events.id')
        ->where('attendance.user_id', '=', $userId)
        ->where('attendance.wishlist', '=', true)
        ->pluck('events.id')
        ->toArray();

    return $wishlistEvents;
}

public function addToWishlist($eventId)
{
    $userId = auth()->id();


    $attended = DB::table('attendance')
        ->where('user_id', $userId)
        ->where('event_id', $eventId)
        ->exists();


    DB::table('attendance')->updateOrInsert(
        ['user_id' => $userId, 'event_id' => $eventId],
        ['wishlist' => true]
    );

    return redirect()->back()->with('success', 'Event added to wishlist successfully.');
}

public function removeFromWishlist($eventId)
{
    $userId = auth()->id();


    $attended = DB::table('attendance')
        ->where('user_id', $userId)
        ->where('event_id', $eventId)
        ->exists();


    if ($attended) {
        DB::table('attendance')
            ->where('user_id', $userId)
            ->where('event_id', $eventId)
            ->update(['wishlist' => false]);

        return redirect()->back()->with('success', 'Event removed from wishlist successfully.');
    } else {

        return redirect()->back()->with('error', 'You cannot remove an event from the wishlist if you have not attended it.');
    }
}




public function changeDecision(Request $request, $id)
{

    Log::debug("Entering changeDecision method. Event ID: $id");

    try {

        $request->validate([
            'decision' => 'required|in:Going,Maybe,Not Going',
        ]);

        $userId = Auth::id();


        Attendance::where('user_id', $userId)
            ->where('event_id', $id)
            ->update([
                'participation' => $request->input('decision'),
            ]);

        Log::debug("Decision updated successfully.");

        return redirect()->back()->with('success', 'Decision updated successfully.');
    } catch (\Exception $e) {
        Log::error("Error in changeDecision method: " . $e->getMessage());

        return redirect()->back()->with('error', 'Error updating decision.');
    } finally {
        Log::debug("Exiting changeDecision method");
    }
}

public function removeAttendee($eventId, $userId)
    {
        try {
            Attendance::where('event_id', $eventId)
                ->where('user_id', $userId)
                ->update(['participation' => 'Not Going']);

            return redirect()->back()->with('success', 'Attendee removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error removing attendee.');
        }
    }

    public function filterByTag(Request $request)
{
    $tags = Tag::all();
    $tagId = $request->query('tag');

    $userId = auth()->id();

    if ($tagId && $tagId !== 'all') {
        $publicEvents = Event::where('tag_id', $tagId)
            ->where('ispublic', true)
            ->get();

        $privateEvents = Event::whereIn(
            'id',
            function ($query) use ($userId, $tagId) {
                $query->select('events.id')
                    ->from('events')
                    ->join('eventinvitation', 'events.id', '=', 'eventinvitation.event_id')
                    ->where('eventinvitation.user_invited_id', $userId)
                    ->where('events.ispublic', false)
                    ->where('events.tag_id', $tagId);
            }
        )->get();

        $events = $publicEvents->merge($privateEvents);
    } else {
        return redirect()->route('events.begin');
    }

    $wishlist = $this->checkWishlist();

    foreach ($events as &$event) {
        $event['inWishlist'] = in_array($event['id'], $wishlist);
    }

    return view('events.filtered', compact('events', 'tags'));
}



}


