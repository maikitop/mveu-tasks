@extends('layouts.app')

@section('title', 'Блог - Список постов')

@section('content')
<div class="page-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Список постов</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn">Создать пост</a>
        @endauth
    </div>

    <!-- Форма поиска -->
    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem;">
        <form method="GET" action="{{ route('posts.index') }}" style="display: flex; gap: 0.5rem; align-items: center;">
            <input type="text" name="search" placeholder="Поиск по заголовку..." 
                   value="{{ $search ?? '' }}"
                   style="flex: 1; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
            <button type="submit" class="btn">Поиск</button>
            @if(isset($search) && $search)
                <a href="{{ route('posts.index') }}" class="btn" style="background: #95a5a6;">Сбросить</a>
            @endif
        </form>
        
        @if(isset($search) && $search)
            <p style="margin-top: 0.5rem; color: #666;">
                Результаты поиска по запросу: "<strong>{{ $search }}</strong>"
                @if($posts->count() > 0)
                    <span> (найдено: {{ $posts->count() }})</span>
                @endif
            </p>
        @endif
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($posts->count() > 0)
        <div class="posts-list">
            @foreach($posts as $post)
            <div class="post-item" style="border: 1px solid #ddd; padding: 1.5rem; margin-bottom: 1.5rem; border-radius: 5px;">
                <h3><a href="{{ route('posts.show', $post->id) }}" style="text-decoration: none; color: #2c3e50;">{{ $post->title }}</a></h3>
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">
                    Автор: {{ $post->user->name }} | 
                    Создан: {{ $post->created_at->format('d.m.Y H:i') }}
                </p>
                <p>{{ Str::limit($post->content, 200) }}</p>
                
                <!-- Комментарии к посту -->
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
                    <h4 style="margin-bottom: 0.5rem;">Комментарии ({{ $post->comments->count() }}):</h4>
                    @if($post->comments->count() > 0)
                        @foreach($post->comments->take(3) as $comment)
                        <div style="background: #f8f9fa; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 3px;">
                            <strong>{{ $comment->author_name }}:</strong>
                            <span>{{ Str::limit($comment->content, 100) }}</span>
                        </div>
                        @endforeach
                        @if($post->comments->count() > 3)
                        <small>... и еще {{ $post->comments->count() - 3 }} комментариев</small>
                        @endif
                    @else
                        <p style="color: #6c757d; font-style: italic;">Пока нет комментариев</p>
                    @endif
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                    <div>
                        <a href="{{ route('posts.show', $post->id) }}" style="color: #3498db;">Читать далее</a>
                    </div>
                    @auth
                        @if(Auth::id() === $post->user_id)
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-edit" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                Редактировать
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    Удалить
                                </button>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
                <div style="margin-top: 3rem; display: flex; justify-content: center; align-items: center; gap: 1rem;">
            <div style="color: #666; font-size: 0.9rem;">
                Страница {{ $posts->currentPage() }} из {{ $posts->lastPage() }}
                (показано {{ $posts->count() }} из {{ $posts->total() }} постов)
            </div>
            
            <div style="display: flex; gap: 0.5rem;">
                @if($posts->currentPage() > 1)
                    <a href="{{ $posts->url(1) }}{{ isset($search) && $search ? '&search=' . $search : '' }}" 
                       class="btn" style="padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                        &laquo;
                    </a>
                @endif


                @php
                    $start = max(1, $posts->currentPage() - 2);
                    $end = min($posts->lastPage(), $posts->currentPage() + 2);
                @endphp

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $posts->currentPage())
                        <span class="btn" style="background: #3498db; color: white; padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $posts->url($i) }}{{ isset($search) && $search ? '&search=' . $search : '' }}" 
                           class="btn" style="padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                            {{ $i }}
                        </a>
                    @endif
                @endfor


                @if($posts->currentPage() < $posts->lastPage())
                    <a href="{{ $posts->url($posts->lastPage()) }}{{ isset($search) && $search ? '&search=' . $search : '' }}" 
                       class="btn" style="padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                        &raquo;
                    </a>
                @endif
            </div>
            
    @else
        <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 5px;">
            @if(isset($search) && $search)
                <p>По запросу "<strong>{{ $search }}</strong>" ничего не найдено.</p>
                <a href="{{ route('posts.index') }}" class="btn">Показать все посты</a>
            @else
                <p>Пока нет постов. 
                    @auth
                        <a href="{{ route('posts.create') }}">Создайте первый пост!</a>
                    @else
                        <a href="{{ route('login') }}">Войдите</a>, чтобы создать первый пост!
                    @endauth
                </p>
            @endif
        </div>
    @endif
</div>
@endsection