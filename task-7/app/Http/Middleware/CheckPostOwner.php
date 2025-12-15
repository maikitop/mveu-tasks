<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class CheckPostOwner
{
    public function handle(Request $request, Closure $next)
    {
        $postId = $request->route('id');
        $post = Post::findOrFail($postId);

        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')
                ->with('error', 'У вас нет прав для выполнения этого действия!');
        }

        return $next($request);
    }
}