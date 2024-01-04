<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function submitFeedback(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:bug,feature,improvement',
        ]);

        $feedback = new Feedback;
        $feedback->user_id = auth()->user()->id;
        $feedback->title = $validatedData['title'];
        $feedback->description = $validatedData['description'];
        $feedback->category = $validatedData['category'];
        $feedback->save();

        return redirect()->route('feedback-listing')->with('success', 'Feedback submitted successfully');
    }

    public function feedbacklisting()
    {
        $feedbacks = Feedback::with('comments')
    ->orderBy('created_at', 'desc')
    ->paginate(4);

        return view('feedbacklisting', compact('feedbacks'));
    }

    public function feedbacksearch(Request $request)
    {
        $query = $request->input('q');
        $feedbacks = Feedback::where('title', 'like', '%' . $query . '%')->paginate(4);

        return view('feedbacklisting', compact('feedbacks'));
    }

}

