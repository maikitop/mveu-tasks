@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="page-content">
    <h1>Вход в систему</h1>

    <form method="POST" action="{{ route('login') }}" style="max-width: 400px;">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required autofocus>
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
            <label style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                <span>Запомнить меня</span>
            </label>
        </div>
        
        <button type="submit" class="btn" style="width: 100%;">Войти</button>
        
        <div style="text-align: center; margin-top: 1rem;">
            <p>Нет аккаунта? <a href="{{ route('register') }}" style="color: #3498db;">Зарегистрируйтесь</a></p>
        </div>
    </form>
</div>
@endsection