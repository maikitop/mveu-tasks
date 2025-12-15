@extends('layouts.app')

@section('title', 'Редактирование поста')

@section('content')
<div class="page-content">
    <h1>Редактирование поста</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Заголовок:</label>
            <input type="text" name="title" id="title" 
                   value="{{ old('title', $post->title) }}"
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
            @error('title')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Содержание:</label>
            <textarea name="content" id="content" 
                      style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; height: 300px;" 
                      required>{{ old('content', $post->content) }}</textarea>
            @error('content')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">Обновить пост</button>
            <a href="{{ route('posts.show', $post->id) }}" class="btn" style="background: #95a5a6;">Отмена</a>
        </div>
    </form>
</div>
@endsection