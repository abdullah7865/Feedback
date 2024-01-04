<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeComment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'feedback_id' => 'required|exists:feedbacks,id',
            'content' => 'required|string',
        ]);

        // Process mentions in the content
        $content = $this->processMentions($request->input('content'));

        $comment = Comment::create([
            'user_id' => $request->input('user_id'),
            'feedback_id' => $request->input('feedback_id'),
            'content' => $content,
        ]);

        return redirect()->back()->with('success', 'Comment Posted successfully');
    }

    private function processMentions($content)
    {
        // Use a regular expression to find mentions (e.g., @username)
        preg_match_all('/@(\w+)/', $content, $matches);

        foreach ($matches[1] as $username) {
            // Find the user by username and replace the mention with a link
            $user = User::where('username', $username)->first();
            if ($user) {
                $replace = '<a href="' . route('user.profile', ['user' => $user->id]) . '">@' . $username . '</a>';
                $content = str_replace('@' . $username, $replace, $content);
            }
        }

        return $content;
    }

}
