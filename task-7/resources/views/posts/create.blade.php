@extends('layouts.app')

@section('title', 'Блог - Создание поста')

@section('content')
<div class="page-content">
    <h1>Создание нового поста</h1>

    <form action="{{ route('posts.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Заголовок:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
            @error('title')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="content" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Содержание:</label>
            <textarea name="content" id="content" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; height: 300px;" required>{{ old('content') }}</textarea>
            @error('content')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn">Создать пост</button>
            <a href="{{ route('posts.index') }}" class="btn" style="background: #95a5a6;">Отмена</a>
        </div>
    </form>
</div>
@endsection