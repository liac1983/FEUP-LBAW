<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AboutController;
use APP\Http\Controllers\FaqController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ChangePasswordController;




Route::redirect('/', '/login');


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLog')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showReg')->name('register');
    Route::post('/register', 'register');
});



Route::controller(EventsController::class)->group(function () {

    Route::get('/events-begin', [EventsController::class, 'showEvents'])->name('events.begin');
    Route::get('/event/{id}', 'show')->where('id', '[0-9]+')->name('event.show');
    Route::get('/event/edit', 'editEvent');
    Route::post('/events/create', [EventsController::class, 'createEvent'])->name('events.createEvent');
    Route::get('/events/create', [EventsController::class, 'showCreateForm'])->name('events.create');
    Route::post('/event/delete', 'deleteEvent');
    Route::post('/event/addtowishlist', 'addToWishlist');
    Route::post('/event/removefromwishlist', 'removeFromWishlist');
    Route::get('/events/search', [EventsController::class, 'search'])->name('events.search');
    Route::get('/events/myevents', [EventsController::class, 'showMyEvents'])->name('events.myevents');
    Route::post('/events/send-invitation/{eventId}', [EventsController::class, 'sendInvitation'])->name('event.sendInvitation');
    Route::get('/events/invite/{eventId}', [EventsController::class, 'showInviteForm'])->name('event.invite');
    Route::get('/sent-invitations', [EventsController::class, 'showSentInvitations'])->name('sent_invitations.index');
    Route::get('/received-invitations', [EventsController::class, 'showReceivedInvitations'])->name('received_invitations.index');
    Route::get('/events/going', [EventsController::class, 'showEventsImGoing'])->name('events.going');
    Route::get('/events/wishlist', [EventsController::class, 'showWishlist'])->name('events.wishlist');
    Route::put('/event/changeDecision/{id}', [EventsController::class, 'changeDecision'])->name('event.changeDecision');
    Route::get('/event/{eventId}/remove-attendee/{userId}', [EventsController::class, 'removeAttendee'])->name('remove.attendee');
    Route::get('/events/filterByTag', [EventsController::class, 'filterByTag'])->name('events.filterByTag');

    Route::post('/events/add-to-wishlist/{eventId}', [EventsController::class, 'addToWishlist'])->name('events.addToWishlist');
    Route::post('/events/removeFromWishlist/{eventId}', [EventsController::class, 'removeFromWishlist'])->name('events.removeFromWishlist');
    Route::post('/events/attendance/{eventId}/{participation}', [EventsController::class, 'toggleAttendance'])->name('events.toggleAttendance');


    

});


Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/non-admin-users', 'showNonAdminUsers')->name('admin.nonAdminUsers'); 
    Route::get('/admin/dashboard', 'showAdminDashboard')->name('admin.dashboard');
    Route::put('/admin/suspend-user/{id}', 'suspendUser')->name('admin.suspendUser');
    Route::get('/admin/view-user-info/{id}',  'viewUserInfo')->name('admin.viewUserInfo');
    Route::get('/admin/manage-events', 'manageEvents')->name('admin.manageEvents');
    Route::put('/admin/delete-event/{id}', 'deleteEvent')->name('admin.deleteEvent');
    Route::get('/admin/view-event-info/{id}', 'viewEventInfo')->name('admin.viewEventInfo');
    Route::put('/admin/toggleUserStatus/{id}', 'toggleUserStatus')->name('admin.toggleUserStatus');
    Route::put('/admin/users/{id}/update-status', 'updateUserStatus')->name('admin.updateUserStatus');
});


Route::controller(CommentsController::class)->group(function () {
    Route::get('/comments', [CommentsController::class, 'index'])->name('comments.index');
});




Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');


});




Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/showWishlist', [ProfileController::class, 'showWishlist'])->name('profile.showWishlist');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit-photo', [ProfileController::class, 'editProfilePhotoForm'])->name('profile.editProfileForm');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});


Route::get('/about', [AboutController::class, 'index'])->name('about');



Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

Route::post('/comment/store/{eventId}', [CommentsController::class, 'store'])->name('comment.store');


Route::delete('/comment/delete/{commentId}', [CommentsController::class, 'destroy'])->name('comment.destroy');


//TEST
// Google OAuth Routes
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback/login', [LoginController::class, 'handleGoogleCallback']);

Route::get('register/google', [RegisterController::class, 'redirectToGoogle'])->name('google.register');
Route::get('/auth/google/callback', [RegisterController::class, 'handleGoogleCallback']);


Route::get('register/username', function () {
    return view('auth.username');
})->name('register.username');

Route::post('register/finish', [RegisterController::class, 'completeRegistration'])->name('register.finish');
