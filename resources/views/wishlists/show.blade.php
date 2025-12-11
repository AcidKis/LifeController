@extends('layouts.app')

@section('title', "{$wishlist->title} - LifeFlow")

@section('content')
<div class="container">
    <!-- Хлебные крошки -->
    <nav class="breadcrumb-nav">
        <a href="{{ route('wishlists.index') }}" class="breadcrumb-link">Мои вишлисты</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">{{ Str::limit($wishlist->title, 30) }}</span>
    </nav>

    <!-- Заголовок вишлиста -->
    <div class="wishlist-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="wishlist-title">{{ $wishlist->title }}</h1>
                <div class="visibility-badge {{ $wishlist->visibility === 'public' ? 'public' : ($wishlist->visibility === 'shared' ? 'shared' : 'private') }}">
                    @if($wishlist->visibility === 'public')
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z" />
                    </svg>
                    Публичный
                    @elseif($wishlist->visibility === 'shared')
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z" />
                    </svg>
                    Общий
                    @else
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zM15.1 8H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                    </svg>
                    Личный
                    @endif
                </div>
            </div>

            @if($wishlist->description)
            <p class="wishlist-description">{{ $wishlist->description }}</p>
            @endif

            <!-- Прогресс выполнения -->
            <div class="overall-progress">
                <div class="progress-header">
                    <span class="progress-label">Прогресс выполнения</span>
                    <span class="progress-stats">{{ $wishlist->completed_items }}/{{ $wishlist->total_items }} ({{ $wishlist->progress_percentage }}%)</span>
                </div>
                <div class="progress-bar large">
                    <div class="progress-fill" style="width: {{ $wishlist->progress_percentage }}%"></div>
                </div>
            </div>

            <!-- Мета-информация -->
            <div class="wishlist-meta">
                <div class="meta-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <span>Владелец: <strong>{{ $wishlist->user->name }}</strong></span>
                </div>
                <div class="meta-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                    </svg>
                    <span>Записей: <strong>{{ $wishlist->items->count() }}</strong></span>
                </div>
                <div class="meta-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                    </svg>
                    <span>Создан: <strong>{{ $wishlist->created_at->format('d.m.Y') }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Действия -->
        <div class="header-actions">
            <a href="{{ route('wishlists.edit', $wishlist) }}" class="action-button secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                </svg>
                Редактировать
            </a>
            <button class="action-button primary" onclick="showAddItemForm()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Добавить запись
            </button>
        </div>
    </div>

    <!-- Форма добавления новой записи -->
    <div id="addItemForm" class="add-item-form hidden">
        <div class="form-header">
            <h3>Добавить новую запись</h3>
            <button type="button" class="close-button" onclick="hideAddItemForm()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </button>
        </div>
        <form id="addItemFormElement" method="POST" action="{{ route('wishlist-items.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">

            <div class="form-grid">
                <!-- Поле для загрузки изображения -->
                <div class="form-group full-width">
                    <label for="image">Изображение</label>
                    <div class="image-upload-container">
                        <div class="image-preview" id="imagePreview">
                            <div class="image-preview-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                </svg>
                                <span>Изображение не выбрано</span>
                            </div>
                        </div>
                        <div class="image-upload-controls">
                            <input type="file" id="image" name="image" accept="image/*" class="image-input"
                                onchange="lifeFlow.handleImagePreview(this)">
                            <label for="image" class="image-upload-button">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                </svg>
                                Выбрать изображение
                            </label>
                            <button type="button" class="image-remove-button hidden" onclick="lifeFlow.removeImage()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                                </svg>
                                Удалить
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="title">Название *</label>
                    <input type="text" id="title" name="title" required class="form-input" placeholder="Введите название товара">
                </div>

                <div class="form-group full-width">
                    <label for="description">Описание</label>
                    <textarea id="description" name="description" rows="3" class="form-textarea" placeholder="Добавьте описание товара (необязательно)"></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Цена</label>
                    <input type="number" id="price" name="price" step="0.01" class="form-input" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="url">Ссылка</label>
                    <input type="url" id="url" name="url" class="form-input" placeholder="https://...">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="hideAddItemForm()">Отмена</button>
                <button type="submit" class="btn-primary">Добавить запись</button>
            </div>
        </form>
    </div>

    <!-- Модальное окно редактирования записи -->
    <div id="editItemModal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Редактировать запись</h3>
                <button type="button" class="close-button" onclick="lifeFlow.hideEditModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    </svg>
                </button>
            </div>
            <form id="editItemForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">

                <div class="form-grid">
                    <!-- Поле для загрузки изображения -->
                    <div class="form-group full-width">
                        <label for="edit_image">Изображение</label>
                        <div class="image-upload-container">
                            <div class="image-preview" id="editImagePreview">
                                <div class="image-preview-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                    </svg>
                                    <span>Изображение не выбрано</span>
                                </div>
                            </div>
                            <div class="image-upload-controls">
                                <input type="file" id="edit_image" name="image" accept="image/*" class="image-input"
                                    onchange="lifeFlow.handleEditImagePreview(this)">
                                <label for="edit_image" class="image-upload-button">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                    </svg>
                                    Выбрать изображение
                                </label>
                                <button type="button" class="image-remove-button hidden" onclick="lifeFlow.removeEditImage()">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                                    </svg>
                                    Удалить
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="edit_title">Название *</label>
                        <input type="text" id="edit_title" name="title" required class="form-input" placeholder="Введите название товара">
                    </div>

                    <div class="form-group full-width">
                        <label for="edit_description">Описание</label>
                        <textarea id="edit_description" name="description" rows="3" class="form-textarea" placeholder="Добавьте описание товара (необязательно)"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_price">Цена</label>
                        <input type="number" id="edit_price" name="price" step="0.01" class="form-input" placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label for="edit_url">Ссылка</label>
                        <input type="url" id="edit_url" name="url" class="form-input" placeholder="https://...">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="lifeFlow.hideEditModal()">Отмена</button>
                    <button type="submit" class="btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Список записей вишлиста -->
    <div class="wishlist-items-section">
        <div class="section-header">
            <h2>Записи вишлиста</h2>
            <div class="items-count">{{ $wishlist->items->count() }} записей</div>
        </div>

        @if($wishlist->items->count() > 0)
        <div class="items-grid">
            @foreach($wishlist->items as $item)
            <div class="wishlist-item {{ $item->completed ? 'completed' : '' }}" data-item-id="{{ $item->id }}">
                <div class="item-checkbox">
                    @if($wishlist->canEdit(Auth::user()))
                    <input type="checkbox" id="item-{{ $item->id }}" {{ $item->completed ? 'checked' : '' }}
                        data-url="{{ route('wishlist-items.toggle', $item->id) }}"
                        onchange="lifeFlow.toggleItemCompletion(this)">
                    <label for="item-{{ $item->id }}"></label>
                    @endif
                </div>

                <!-- Картинка -->
                <div class="item-image">
                    @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="item-image-placeholder" style="display: none;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                        </svg>
                    </div>
                    @else
                    <div class="item-image-placeholder">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                        </svg>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <div class="item-header">
                        <h3 class="item-title">{{ $item->title }}</h3>
                        @if($item->price)
                        <span class="item-price">{{ number_format($item->price, 0, ',', ' ') }} ₽</span>
                        @endif
                    </div>

                    @if($item->description)
                    <p class="item-description">{{ $item->description }}</p>
                    @endif

                    <div class="item-meta">
                        @if($item->url)
                        <a href="{{ $item->url }}" target="_blank" class="item-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z" />
                            </svg>
                            Перейти к товару
                        </a>
                        @endif

                        @if($wishlist->canEdit(Auth::user()))
                        <div class="item-actions">
                            <button class="icon-button" onclick="lifeFlow.editItem({{ $item->id }})" title="Редактировать">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                </svg>
                            </button>
                            <button class="icon-button danger"
                                data-url="{{ route('wishlist-items.destroy', $item->id) }}"
                                onclick="lifeFlow.deleteItem(this)"
                                title="Удалить">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-items">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" fill="currentColor" fill-opacity="0.3" />
            </svg>
            <h3>Пока нет записей в вишлисте</h3>
            <p>Добавьте первую запись, чтобы начать заполнять вишлист</p>
            <button class="cta-button" onclick="showAddItemForm()">Добавить первую запись</button>
        </div>
        @endif
    </div>
</div>
@endsection