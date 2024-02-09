<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function show()
    {
        $userId = Auth::id();
        
        $wishlist = DB::table('attendance')
            ->join('events', 'attendance.event_id', '=', 'events.id')
            ->where('attendance.user_id', '=', $userId)
            ->where('attendance.wishlist', '=', true)
            ->select('events.*')
            ->get();

        
        return view('profile.index', ['wishlist' => $wishlist]);
    }

    public function editProfilePhotoForm()
    {
        return view('profile.edit_photo');
    }

    public function editProfileForm()
    {
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    $dataToUpdate = [
        'username' => $request->input('username'),
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ];

    // Update only the fields that are provided in the request
    $user->update(array_filter($dataToUpdate));

    if ($request->hasFile('profile_photo')) {
        $image = $request->file('profile_photo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('profile_photos'), $imageName);

        $profilePhotoPath = 'profile_photos/' . $imageName;

        // Update the profile photo path
        $user->profile_photo = $profilePhotoPath;
        $user->save();
    }

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
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

        return view('profile.index', ['wishlist' => $wishlist]);
    }

}