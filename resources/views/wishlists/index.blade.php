@extends('layouts.app')

@section('title', 'LifeFlow - Мои вишлисты')

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">Мои вишлисты</h1>
        @can('create', \App\Models\Wishlist::class)
        <a href="{{ route('wishlists.create') }}" class="create-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="currentColor" />
            </svg>
            Создать вишлист
        </a>
        @endcan
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($wishlists->count() > 0)
    <div class="wishlists-grid">
        @foreach($wishlists as $wishlist)
        <div class="wishlist-card" data-id="{{ $wishlist->id }}">
            <div class="card-content">
                <div class="card-header">
                    <h3 class="card-title">{{ $wishlist->title }}</h3>
                    <span class="card-tag {{ $wishlist->visibility === 'public' ? 'shared' : '' }}">
                        @if($wishlist->visibility === 'public')
                        Публичный
                        @elseif($wishlist->visibility === 'shared')
                        Общий
                        @else
                        Личный
                        @endif
                    </span>
                </div>

                @if($wishlist->description)
                <p class="card-description">{{ Str::limit($wishlist->description, 100) }}</p>
                @endif

                <div class="progress-container">
                    <div class="progress-info">
                        <span>Прогресс выполнения</span>
                        <span>{{ $wishlist->completed_items_count }}/{{ $wishlist->items_count }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $wishlist->progress_percentage }}%"></div>
                    </div>
                </div>

                <div class="card-meta">
                    <div class="meta-left">
                        <span>Владелец: {{ $wishlist->user->name }}</span>
                        <span>Записей: {{ $wishlist->total_items }}</span>
                        @if($wishlist->editorUsers->count() > 0)
                        <span>Редакторы: {{ $wishlist->editorUsers->count() }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" fill="currentColor" fill-opacity="0.3" />
        </svg>
        <h3>У вас пока нет вишлистов</h3>
        <p>Создайте свой первый вишлист и начните добавлять желания</p>
        @can('create', \App\Models\Wishlist::class)
        <a href="{{ route('wishlists.create') }}" class="cta-button">Создать первый вишлист</a>
        @endcan
    </div>
    @endif
</div>
@endsection