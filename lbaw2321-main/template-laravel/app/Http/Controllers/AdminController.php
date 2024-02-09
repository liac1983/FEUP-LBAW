<?php

    namespace App\Http\Controllers;

    use App\Models\Event;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\Controller;
    use App\Models\User;

    class AdminController extends Controller
    {
    public function showNonAdminUsers()
    {
        $nonAdminUsers = User::where('isadmin', false)->get();

        return view('nonAdminUsers', ['nonAdminUsers' => $nonAdminUsers]);
    }
    public function suspendUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            // Handle the case where the user is not found.
            abort(404);
        }

        // Update the user's status to "Suspended"
        DB::table('users')->updateOrInsert(
            ['id' => $user->id],
            ['userstatus' => 'Suspended']
        );

        return redirect()->route('admin.nonAdminUsers');
    }
    public function viewUserInfo($id)
    {
        $user = User::find($id);

        if (!$user) {
            // Handle the case where the user is not found.
            abort(404);
            // ERROR
        }

        return view('viewUserInfo', ['user' => $user]);
    }
    public function manageEvents()
    {
    // Fetch events ordered by start time
    $events = Event::orderBy('startdatetime', 'asc')->get();

    return view('manageEvents', ['events' => $events]);
    }

    public function viewEventInfo($id)
        {
            $event = Event::find($id);

            if (!$event) {
                abort(404); // Handle the case where the event with the given ID is not found.
            }

            return view('viewEventInfo', ['event' => $event]);
        }

    // Add the method for deleting an event if you haven't already
    public function deleteEvent($id)
    {
        
        return redirect()->back()->with('success', 'Event deleted successfully.');
    }
    public function toggleUserStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Toggle the user's status between "Suspended" and "Active"
        $user->userstatus = $user->userstatus == 'Suspended' ? 'Active' : 'Suspended';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
    public function updateUserStatus($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Validate the request
        $request->validate([
            'userstatus' => 'required|in:Active,Suspended,Banned',
            'token' => 'required', // Add validation for the token
        ]);

        // Verify the token
        $token = $request->input('token');
        // You may want to add further validation or verification logic for the token
        // For example, you can store the token in the session and compare it here

        // Update the user's status
        $user->userstatus = $request->userstatus;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    public function showAdminDashboard()
    {
    $nonAdminUsers = User::where('isadmin', false)->get();

    $events = Event::orderBy('startdatetime', 'asc')->get();

    return view('dashboard', ['nonAdminUsers' => $nonAdminUsers],['events' => $events]);
    }

}
