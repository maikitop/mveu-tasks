<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Мой Сайт</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
        }

        .nav-links li {
            margin-left: 1.5rem;
            position: relative;
        }
        .nav-links li:hover ul {
         display: block !important;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #3498db;
        }

        .nav-links .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-links .user-name {
            color: #ecf0f1;
        }

        .nav-links .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 3px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .nav-links .btn-logout:hover {
            background: #c0392b;
        }
        

        main {
            min-height: calc(100vh - 140px);
            padding: 2rem 0;
        }

        footer {
            background: #34495e;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        }

        .page-content {
            background: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 3px;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-edit {
            background: #f39c12;
        }

        .btn-edit:hover {
            background: #e67e22;
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">Мой Сайт</div>
                <ul class="nav-links">
    <li><a href="{{ route('home') }}">Главная</a></li>
    <li><a href="{{ route('about') }}">О нас</a></li>
    <li><a href="{{ route('contact') }}">Контакты</a></li>
    <li>
        <a href="{{ route('posts.index') }}">Блог</a>
        <ul style="display: none; position: absolute; background: #2c3e50; padding: 0.5rem;">
            <li><a href="{{ route('posts.index') }}" style="padding: 0.5rem 1rem; display: block;">Обычная версия</a></li>
            <li><a href="{{ route('posts.api') }}" style="padding: 0.5rem 1rem; display: block;">API версия</a></li>
        </ul>
    </li>

    @auth
        <li style="display: flex; align-items: center; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <img src="{{ Auth::user()->getAvatarUrl() }}" alt="Аватар" 
                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                <span>{{ Auth::user()->name }}</span>
            </div>
            <a href="{{ route('profile.edit') }}" style="color: white; margin-left: 1rem;">Профиль</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 1rem;">
                @csrf
                <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 3px; cursor: pointer;">
                    Выйти
                </button>
            </form>
        </li>
    @else
        <li><a href="{{ route('login') }}">Войти</a></li>
        <li><a href="{{ route('register') }}">Регистрация</a></li>
    @endauth
</ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Мой Сайт. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>