@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="page-content">
    <a href="{{ route('posts.index') }}" style="color: #3498db; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Назад к списку постов</a>

    <article style="margin-bottom: 3rem;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
            <h1 style="flex: 1; margin-right: 1rem;">{{ $post->title }}</h1>
            @auth
                @if(Auth::id() === $post->user_id)
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-edit">
                        Редактировать
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">
                            Удалить
                        </button>
                    </form>
                </div>
                @endif
            @endauth
        </div>
        
        <div style="color: #6c757d; margin-bottom: 1rem;">
            <small>Автор: {{ $post->user->name }} | Опубликован: {{ $post->created_at->format('d.m.Y H:i') }}</small>
            @if($post->updated_at != $post->created_at)
                <small style="margin-left: 1rem;">Обновлен: {{ $post->updated_at->format('d.m.Y H:i') }}</small>
            @endif
        </div>
        
        <div style="line-height: 1.6; margin-bottom: 2rem; white-space: pre-line;">
            {{ $post->content }}
        </div>
    </article>

    <!-- Секция комментариев -->
    <section>
        <h2>Комментарии ({{ $post->comments->count() }})</h2>
        
        @if($post->comments->count() > 0)
            <div style="margin-bottom: 2rem;">
                @foreach($post->comments as $comment)
                <div style="border: 1px solid #eee; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                        <strong>{{ $comment->author_name }}</strong>
                        @auth
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Удалить комментарий?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 0.8rem;">
                                Удалить
                            </button>
                        </form>
                        @endauth
                    </div>
                    <p style="margin-bottom: 0.5rem; white-space: pre-line;">{{ $comment->content }}</p>
                    <small style="color: #6c757d;">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                </div>
                @endforeach
            </div>
        @else
            <p style="color: #6c757d; font-style: italic; margin-bottom: 2rem;">Пока нет комментариев. 
                @auth
                    Будьте первым!
                @else
                    <a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий!
                @endauth
            </p>
        @endif

        <!-- Форма добавления комментария -->
        @auth
        <div style="border-top: 2px solid #eee; padding-top: 2rem;">
            <h3>Добавить комментарий</h3>
            <form action="{{ route('comments.store', $post->id) }}" method="POST" style="max-width: 600px;">
                @csrf
                
                <div style="margin-bottom: 1rem;">
                    <label for="author_name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Ваше имя:</label>
                    <input type="text" name="author_name" id="author_name" value="{{ old('author_name', Auth::user()->name) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
                    @error('author_name')
                        <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Комментарий:</label>
                    <textarea name="content" id="content" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; height: 100px;" required>{{ old('content') }}</textarea>
                    @error('content')
                        <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn">Добавить комментарий</button>
            </form>
        </div>
        @else
        <div style="border-top: 2px solid #eee; padding-top: 2rem;">
            <p>Чтобы оставить комментарий, <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a>.</p>
        </div>
        @endauth
    </section>
</div>
@endsection