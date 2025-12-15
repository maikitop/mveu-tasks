@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
<div class="page-content">
    <h1>Редактирование профиля</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 3rem; align-items: flex-start;">
        <!-- Форма -->
        <div style="flex: 1;">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="max-width: 500px;">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Имя:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
                    @error('name')
                        <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" required>
                    @error('email')
                        <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 1rem;">
                    <label for="avatar" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Аватар:</label>
                    <input type="file" name="avatar" id="avatar" 
                           style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px;" accept="image/*">
                    @error('avatar')
                        <span style="color: #e74c3c; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn">Сохранить</button>
                    @if(Auth::user()->avatar)
                        <button type="button" onclick="document.getElementById('remove-avatar-form').submit();" 
                                class="btn" style="background: #e74c3c;">
                            Удалить аватар
                        </button>
                    @endif
                </div>
            </form>

            @if(Auth::user()->avatar)
            <form id="remove-avatar-form" action="{{ route('profile.avatar.remove') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        <!-- Предпросмотр -->
        <div style="flex: 0 0 200px; text-align: center;">
            <h3 style="margin-bottom: 1rem;">Текущий аватар</h3>
            <img src="{{ Auth::user()->getAvatarUrl() }}" alt="Аватар" id="avatar-preview"
                 style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #3498db;">
            <p style="margin-top: 0.5rem; color: #666;">
                @if(Auth::user()->avatar)
                    Загруженный аватар
                @else
                    Аватар по умолчанию
                @endif
            </p>
        </div>
    </div>

<script>
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection