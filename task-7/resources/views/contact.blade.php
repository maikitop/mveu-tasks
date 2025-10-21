@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="page-content">
    <h1>Свяжитесь с нами</h1>
    <p>Мы всегда рады ответить на ваши вопросы и обсудить возможное сотрудничество.</p>
    
    <div style="margin: 2rem 0;">
        <h2>Контактная информация:</h2>
        <p><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 123</p>
        <p><strong>Телефон:</strong> +7 (495) 123-45-67</p>
        <p><strong>Email:</strong> info@example.com</p>
    </div>

    <h2>Форма обратной связи</h2>
    <form style="max-width: 500px;">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Ваше имя:</label>
            <input type="text" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Email:</label>
            <input type="email" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem;">Сообщение:</label>
            <textarea style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; height: 100px;"></textarea>
        </div>
        
        <button type="submit" class="btn">Отправить сообщение</button>
    </form>
</div>
@endsection