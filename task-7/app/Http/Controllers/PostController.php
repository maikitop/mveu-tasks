<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'apiIndex', 'apiShow']);
    }

   public function index(Request $request)
{
    $search = $request->input('search');
    
    $posts = Post::with(['comments', 'user'])
        ->search($search)
        ->orderBy('created_at', 'desc')
        ->paginate(5);
    
    return view('posts.index', compact('posts', 'search'));
}

    public function show($id)
    {
        $post = Post::with(['comments', 'user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

   public function apiIndex(Request $request)
{
    try {
        $search = $request->input('search');
        
        $posts = Post::with(['comments', 'user'])
            ->search($search)
            ->orderBy('created_at', 'desc')
            ->get(); 
        
        return response()->json([
            'success' => true,
            'data' => $posts, 
            'search_term' => $search
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ошибка при загрузке постов',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function apiShow($id)
    {
        $post = Post::with(['comments', 'user'])->find($id);
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Пост не найден'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Пост успешно создан',
                'data' => $post
            ], 201);
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        
        if ($post->user_id !== Auth::id()) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для редактирования этого поста'
                ], 403);
            }
            return redirect()->route('posts.index')->with('error', 'У вас нет прав для редактирования этого поста!');
        }

        $post->update($request->all());

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Пост успешно обновлен',
                'data' => $post
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->user_id !== Auth::id()) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'У вас нет прав для удаления этого поста'
                ], 403);
            }
            return redirect()->route('posts.index')->with('error', 'У вас нет прав для удаления этого поста!');
        }

        $post->delete();

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Пост успешно удален'
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален!');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'У вас нет прав для редактирования этого поста!');
        }

        return view('posts.edit', compact('post'));
    }
    
}
