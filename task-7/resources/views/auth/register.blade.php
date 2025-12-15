@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="page-content">
    <h1>Регистрация</h1>

    <form method="POST" action="{{ route('register') }}" style="max-width: 400px;">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Имя:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required autofocus>
            @error('name')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
            @error('email')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Пароль:</label>
            <input type="password" name="password" id="password" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
            @error('password')
                <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Подтверждение пароля:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Зарегистрироваться</button>
        
        <div style="text-align: center; margin-top: 1rem;">
            <p>Уже есть аккаунт? <a href="{{ route('login') }}" style="color: #3498db;">Войдите</a></p>
        </div>
    </form>
</div>
@endsection