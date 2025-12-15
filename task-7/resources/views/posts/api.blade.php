@extends('layouts.app')

@section('title', 'Посты через API')

@section('content')
<div class="page-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Посты через API (Fetch)</h1>
        <div>
            <button onclick="loadPosts()" class="btn">Обновить</button>
            <a href="{{ route('posts.create') }}" class="btn">Создать пост</a>
            <a href="{{ route('posts.index') }}" class="btn" style="background: #95a5a6;">Обычная версия</a>
        </div>
    </div>

    <div id="loading" style="text-align: center; padding: 2rem;">
        <p>Загрузка постов...</p>
    </div>

    <div id="posts-container">
        <!-- Посты будут загружены здесь -->
    </div>

    <div id="error-message" style="display: none; background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
    </div>
</div>

<script>
// Загрузка постов при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadPosts();
});

// Функция загрузки постов через Fetch API
async function loadPosts() {
    const loading = document.getElementById('loading');
    const container = document.getElementById('posts-container');
    const errorDiv = document.getElementById('error-message');
    
    // Показываем загрузку
    loading.style.display = 'block';
    container.innerHTML = '';
    errorDiv.style.display = 'none';

    try {
        const response = await fetch('/api/posts');
        
        if (!response.ok) {
            throw new Error('Ошибка сети: ' + response.status);
        }
        
        const result = await response.json();

        if (result.success) {
            displayPosts(result.data);
        } else {
            throw new Error(result.message || 'Ошибка при загрузке постов');
        }
    } catch (error) {
        console.error('Ошибка:', error);
        showError('Не удалось загрузить посты: ' + error.message);
    } finally {
        loading.style.display = 'none';
    }
}

// Функция отображения постов
function displayPosts(posts) {
    const container = document.getElementById('posts-container');
    
    if (!posts || posts.length === 0) {
        container.innerHTML = '<p>Пока нет постов.</p>';
        return;
    }

    let html = '';
    
posts.forEach(post => {
    // Безопасное получение данных
    const postId = post.id || 0;
    const title = post.title || 'Без названия';
    const content = post.content || '';
    const userName = post.user ? post.user.name : 'Неизвестный автор';
    const createdDate = post.created_at ? new Date(post.created_at).toLocaleDateString('ru-RU') : 'Неизвестно';
    const comments = post.comments || [];
    const userId = post.user_id || 0;
    const currentUserId = parseInt('{{ Auth::id() ?? 0 }}') || 0;
    const canEdit = userId === currentUserId;

    // Формируем HTML для комментариев  
    let commentsHtml = '';
    if (comments.length > 0) {
        comments.slice(0, 3).forEach(comment => {
            const commentContent = comment.content ? comment.content.substring(0, 100) : '';
            const commentAuthor = comment.author_name || 'Аноним';
            commentsHtml += `
            <div style="background: #f8f9fa; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 3px;">
                <strong>${commentAuthor}:</strong>
                <span>${commentContent}${comment.content && comment.content.length > 100 ? '...' : ''}</span>
            </div>
            `;
        });
        
        if (comments.length > 3) {
            commentsHtml += `<small>... и еще ${comments.length - 3} комментариев</small>`;
        }
    } else {
        commentsHtml = '<p style="color: #6c757d; font-style: italic;">Пока нет комментариев</p>';
    }

    // Формируем кнопки редактирования/удаления
    let editButtons = '';
    if (canEdit) {
        editButtons = `
            <div style="display: flex; gap: 0.5rem;">
                <a href="/posts/${postId}/edit" style="background: #f39c12; color: white; padding: 0.5rem 1rem; border-radius: 3px; text-decoration: none; font-size: 0.875rem;">
                    Редактировать
                </a>
                <button onclick="deletePost(${postId})" style="background: #e74c3c; color: white; border: none; padding: 0.5rem 1rem; border-radius: 3px; cursor: pointer; font-size: 0.875rem;">
                    Удалить
                </button>
            </div>
        `;
    }

    // Формируем HTML для поста
    html += `
    <div class="post-item" style="border: 1px solid #ddd; padding: 1.5rem; margin-bottom: 1.5rem; border-radius: 5px;">
        <h3>
            <a href="/posts/${postId}" style="text-decoration: none; color: #2c3e50;">
                ${title}
            </a>
        </h3>
        
        <div style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">
            Автор: ${userName} | 
            Создан: ${createdDate}
        </div>
        
        <p>${content.substring(0, 200)}${content.length > 200 ? '...' : ''}</p>
        
        <!-- Комментарии -->
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 0.5rem;">Комментарии (${comments.length}):</h4>
            ${commentsHtml}
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
            <div>
                <a href="/posts/${postId}" style="color: #3498db;">Читать далее</a>
                <button onclick="loadPost(${postId})" style="background: #3498db; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 3px; cursor: pointer; margin-left: 1rem; font-size: 0.8rem;">
                    Загрузить через API
                </button>
            </div>
            
            ${editButtons}
        </div>
    </div>
    `;
});

container.innerHTML = html;
}

// Функция загрузки одного поста
async function loadPost(postId) {
    try {
        const response = await fetch('/api/posts/' + postId);
        
        if (!response.ok) {
            throw new Error('Ошибка сети: ' + response.status);
        }
        
        const result = await response.json();

        if (result.success) {
            alert('Пост "' + result.data.title + '" загружен через API!');
            console.log('Данные поста:', result.data);
        } else {
            throw new Error(result.message || 'Ошибка при загрузке поста');
        }
    } catch (error) {
        console.error('Ошибка:', error);
        showError('Не удалось загрузить пост: ' + error.message);
    }
}

// Функция удаления поста
async function deletePost(postId) {
    if (!confirm('Вы уверены, что хотите удалить этот пост?')) {
        return;
    }

    try {
        const response = await fetch('/api/posts/' + postId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            showMessage('Пост успешно удален', 'success');
            loadPosts(); // Перезагружаем список
        } else {
            throw new Error(result.message || 'Ошибка при удалении поста');
        }
    } catch (error) {
        console.error('Ошибка:', error);
        showError('Не удалось удалить пост: ' + error.message);
    }
}

// Функция показа сообщения об ошибке
function showError(message) {
    const errorDiv = document.getElementById('error-message');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

// Функция показа успешного сообщения
function showMessage(message, type) {
    const bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
    const textColor = type === 'success' ? '#155724' : '#721c24';
    
    const messageDiv = document.createElement('div');
    messageDiv.style.background = bgColor;
    messageDiv.style.color = textColor;
    messageDiv.style.padding = '1rem';
    messageDiv.style.borderRadius = '5px';
    messageDiv.style.marginBottom = '1rem';
    messageDiv.textContent = message;
    
    const container = document.querySelector('.page-content');
    container.insertBefore(messageDiv, container.firstChild);
    
    // Автоматическое удаление сообщения через 5 секунд
    setTimeout(function() {
        if (messageDiv.parentNode) {
            messageDiv.parentNode.removeChild(messageDiv);
        }
    }, 5000);
}
</script>
@endsection