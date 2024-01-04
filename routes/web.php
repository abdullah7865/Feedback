<?php

use App\Models\Feedback;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function () {
Route::get('/', function () {
    return view('feedbackfrom');
});

//Feedback routes
Route::post('/submit-feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/feedback-listing', [FeedbackController::class, 'feedbacklisting'])->name('feedback-listing');
Route::get('/search', [FeedbackController::class, 'feedbacksearch'])->name('search');

//comment routes
Route::post('/comments/store', [CommentController::class, 'storeComment'])->name('comments.store');
//user profile routes

Route::get('/user-profile', [UserProfileController::class, 'show'])->name('user.profile');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
