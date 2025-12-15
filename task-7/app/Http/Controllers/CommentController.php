<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        // Защищаем все методы комментариев
        $this->middleware('auth');
    }

    // Сохранение комментария
    public function store(Request $request, $postId)
    {
        $request->validate([
            'author_name' => 'required|max:255',
            'content' => 'required',
        ]);

        Comment::create([
            'post_id' => $postId,
            'author_name' => $request->author_name,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $postId)->with('success', 'Комментарий добавлен!');
    }

    // Удаление комментария
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId)->with('success', 'Комментарий удален!');
    }
}