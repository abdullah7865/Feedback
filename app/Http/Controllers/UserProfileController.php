<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
      public function show()
    {
        $user = auth()->user();
        $feedbackItems = $user->feedback()->paginate(4);
        return view('profile', compact('user', 'feedbackItems'));
    }
}
