@extends('layouts.app')

@section('title', 'Создание вишлиста - LifeFlow')

@section('content')
<div class="container">
    <!-- Хлебные крошки -->
    <nav class="breadcrumb-nav">
        <a href="{{ route('wishlists.index') }}" class="breadcrumb-link">Мои вишлисты</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Создание вишлиста</span>
    </nav>

    <!-- Заголовок -->
    <div class="page-header">
        <h1 class="page-title">Создание нового вишлиста</h1>
    </div>

    <!-- Форма создания -->
    <div class="edit-wishlist-form">
        <form action="{{ route('wishlists.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <!-- Основная информация -->
                <div class="form-group full-width">
                    <label for="title">Название вишлиста *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="form-input" placeholder="Введите название вишлиста">
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">Описание</label>
                    <textarea id="description" name="description" rows="4" class="form-textarea" placeholder="Добавьте описание вишлиста (необязательно)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Настройки видимости -->
                <div class="form-group full-width">
                    <label class="form-label">Кто может просматривать вишлист *</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="visibility" value="public" {{ old('visibility') === 'public' ? 'checked' : 'checked' }} onchange="toggleUserSelection()">
                            <span class="radio-custom"></span>
                            <div class="radio-content">
                                <strong>Публичный</strong>
                                <p>Все пользователи могут просматривать этот вишлист</p>
                            </div>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="visibility" value="private" {{ old('visibility') === 'private' ? 'checked' : '' }} onchange="toggleUserSelection()">
                            <span class="radio-custom"></span>
                            <div class="radio-content">
                                <strong>Личный</strong>
                                <p>Только вы можете просматривать этот вишлист</p>
                            </div>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="visibility" value="shared" {{ old('visibility') === 'shared' ? 'checked' : '' }} onchange="toggleUserSelection()">
                            <span class="radio-custom"></span>
                            <div class="radio-content">
                                <strong>Общий</strong>
                                <p>Только выбранные пользователи могут просматривать этот вишлист</p>
                            </div>
                        </label>
                    </div>
                    @error('visibility')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Выбор пользователей для просмотра -->
                <div id="viewer-users-section" class="form-group full-width" style="display: {{ old('visibility') === 'shared' ? 'block' : 'none' }}">
                    <label for="viewer_users">Выберите пользователей для просмотра</label>
                    <div class="users-selection">
                        @foreach($users as $user)
                            <label class="user-checkbox">
                                <input type="checkbox" name="viewer_users[]" value="{{ $user->id }}"
                                    {{ in_array($user->id, old('viewer_users', [])) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <div class="user-info">
                                    <div class="user-avatar-small">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $user->name }}</span>
                                    <span class="user-email">{{ $user->email }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('viewer_users')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Настройки редактирования -->
                <div class="form-group full-width">
                    <label class="form-label">Кто может редактировать вишлист *</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="edit_permission" value="owner" {{ old('edit_permission') === 'owner' ? 'checked' : 'checked' }} onchange="toggleEditorSelection()">
                            <span class="radio-custom"></span>
                            <div class="radio-content">
                                <strong>Только владелец</strong>
                                <p>Только вы можете редактировать этот вишлист</p>
                            </div>
                        </label>

                        <label class="radio-option">
                            <input type="radio" name="edit_permission" value="selected" {{ old('edit_permission') === 'selected' ? 'checked' : '' }} onchange="toggleEditorSelection()">
                            <span class="radio-custom"></span>
                            <div class="radio-content">
                                <strong>Выбранные пользователи</strong>
                                <p>Только выбранные пользователи могут редактировать этот вишлист</p>
                            </div>
                        </label>
                    </div>
                    @error('edit_permission')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Выбор пользователей для редактирования -->
                <div id="editor-users-section" class="form-group full-width" style="display: {{ old('edit_permission') === 'selected' ? 'block' : 'none' }}">
                    <label for="editor_users">Выберите пользователей для редактирования</label>
                    <div class="users-selection">
                        @foreach($users as $user)
                            <label class="user-checkbox">
                                <input type="checkbox" name="editor_users[]" value="{{ $user->id }}"
                                    {{ in_array($user->id, old('editor_users', [])) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <div class="user-info">
                                    <div class="user-avatar-small">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $user->name }}</span>
                                    <span class="user-email">{{ $user->email }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('editor_users')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('wishlists.index') }}" class="btn-secondary">Отмена</a>
                <button type="submit" class="btn-primary">Создать вишлист</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Стили из файла edit.blade.php */
.edit-wishlist-form {
    background: var(--gradient-card);
    border-radius: 20px;
    padding: 2.5rem;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
}

.edit-wishlist-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-primary);
}

.form-label {
    color: var(--text-light);
    margin-bottom: 1rem;
    font-weight: 500;
    display: block;
}

.radio-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.radio-option {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.2rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.radio-option:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(128, 0, 0, 0.3);
}

.radio-option input[type="radio"]:checked + .radio-custom {
    background: var(--gradient-primary);
    border-color: transparent;
}

.radio-option input[type="radio"]:checked + .radio-custom::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
}

.radio-option input[type="radio"] {
    display: none;
}

.radio-custom {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: block;
    position: relative;
    margin-top: 0.2rem;
    flex-shrink: 0;
}

.radio-content {
    flex: 1;
}

.radio-content strong {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 0.3rem;
    display: block;
}

.radio-content p {
    color: var(--text-gray);
    font-size: 0.9rem;
    line-height: 1.4;
}

.users-selection {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 0.8rem;
    max-height: 300px;
    overflow-y: auto;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.user-checkbox {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-checkbox:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(128, 0, 0, 0.3);
}

.user-checkbox input[type="checkbox"]:checked + .checkbox-custom {
    background: var(--gradient-primary);
    border-color: transparent;
}

.user-checkbox input[type="checkbox"]:checked + .checkbox-custom::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.user-checkbox input[type="checkbox"] {
    display: none;
}

.checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    display: block;
    position: relative;
    flex-shrink: 0;
}

.user-info {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.user-avatar-small {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.user-name {
    color: var(--text-light);
    font-weight: 500;
    font-size: 0.95rem;
}

.user-email {
    color: var(--text-gray);
    font-size: 0.8rem;
    margin-left: auto;
}

.form-error {
    color: #ff6b6b;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

@media (max-width: 768px) {
    .edit-wishlist-form {
        padding: 1.5rem;
    }
    
    .users-selection {
        grid-template-columns: 1fr;
    }
    
    .user-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.3rem;
    }
    
    .user-email {
        margin-left: 0;
        font-size: 0.75rem;
    }
}
</style>

<script>
function toggleUserSelection() {
    const viewerSection = document.getElementById('viewer-users-section');
    const visibilityShared = document.querySelector('input[name="visibility"][value="shared"]').checked;
    
    if (visibilityShared) {
        viewerSection.style.display = 'block';
    } else {
        viewerSection.style.display = 'none';
    }
}

function toggleEditorSelection() {
    const editorSection = document.getElementById('editor-users-section');
    const editSelected = document.querySelector('input[name="edit_permission"][value="selected"]').checked;
    
    if (editSelected) {
        editorSection.style.display = 'block';
    } else {
        editorSection.style.display = 'none';
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    toggleUserSelection();
    toggleEditorSelection();
});
</script>
@endsection