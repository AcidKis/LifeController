@extends('layouts.app')

@section('title', 'WishApp - Мои вишлисты')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Мои вишлисты</h1>
        <button class="create-button">+ Создать вишлист</button>
    </div>
    
    <div class="wishlists-grid">
        <!-- Карточка вишлиста 1 -->
        <div class="wishlist-card" data-id="1">
            <div class="card-content">
                <div class="card-header">
                    <h3 class="card-title">Подарки на день рождения</h3>
                    <span class="card-tag">Личный</span>
                </div>
                <p class="card-description">Список подарков, которые я хочу получить на день рождения</p>
                
                <div class="progress-container">
                    <div class="progress-info">
                        <span>Прогресс выполнения</span>
                        <span>3/8</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 37.5%"></div>
                    </div>
                </div>
                
                <div class="card-meta">
                    <div class="meta-left">
                        <span>Владелец: Я</span>
                        <span>Записей: 8</span>
                    </div>
                    <div class="meta-right">
                        <span>Создан: 15.10.2023</span>
                        <span>Обновлен: 22.10.2023</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Карточка вишлиста 2 -->
        <div class="wishlist-card" data-id="2">
            <div class="card-content">
                <div class="card-header">
                    <h3 class="card-title">Путешествия 2024</h3>
                    <span class="card-tag shared">Общий</span>
                </div>
                <p class="card-description">Список стран и городов, которые хочу посетить в следующем году</p>
                
                <div class="progress-container">
                    <div class="progress-info">
                        <span>Прогресс выполнения</span>
                        <span>2/12</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 16.7%"></div>
                    </div>
                </div>
                
                <div class="card-meta">
                    <div class="meta-left">
                        <span>Владелец: Я и друзья</span>
                        <span>Записей: 12</span>
                    </div>
                    <div class="meta-right">
                        <span>Создан: 05.09.2023</span>
                        <span>Обновлен: 18.10.2023</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Карточка вишлиста 3 -->
        <div class="wishlist-card" data-id="3">
            <div class="card-content">
                <div class="card-header">
                    <h3 class="card-title">Книги для прочтения</h3>
                    <span class="card-tag">Личный</span>
                </div>
                <p class="card-description">Список книг, которые планирую прочитать в этом году</p>
                
                <div class="progress-container">
                    <div class="progress-info">
                        <span>Прогресс выполнения</span>
                        <span>7/15</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 46.7%"></div>
                    </div>
                </div>
                
                <div class="card-meta">
                    <div class="meta-left">
                        <span>Владелец: Я</span>
                        <span>Записей: 15</span>
                    </div>
                    <div class="meta-right">
                        <span>Создан: 20.08.2023</span>
                        <span>Обновлен: 20.10.2023</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection