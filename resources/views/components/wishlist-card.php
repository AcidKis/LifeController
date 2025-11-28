{{-- resources/views/components/wishlist-card.blade.php --}}
<div class="wishlist-card" data-id="{{ $list->id }}">
    <div class="card-content">
        <div class="card-header">
            <h3 class="card-title">{{ $list->title }}</h3>
            <span class="card-tag {{ $list->visibility === 'public' ? 'shared' : '' }}">
                @if($list->visibility === 'public')
                    Публичный
                @elseif($list->visibility === 'shared')
                    Общий
                @else
                    Личный
                @endif
            </span>
        </div>

        @if($list->description)
            <p class="card-description">{{ Str::limit($list->description, 100) }}</p>
        @endif

        <div class="progress-container">
            <div class="progress-info">
                <span>Прогресс выполнения</span>
                <span>{{ $list->completed_items }}/{{ $list->total_items }}</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $list->progress_percentage }}%"></div>
            </div>
        </div>

        <div class="card-meta">
            <div class="meta-left">
                <span>Владелец: {{ $list->user->name }}</span>
                <span>Записей: {{ $list->total_items }}</span>
                @if($list->editorUsers->count() > 0)
                    <span>Редакторы: {{ $list->editorUsers->count() }}</span>
                @endif
            </div>
            <div class="meta-right">
                <span>Создан: {{ $list->created_at->format('d.m.Y') }}</span>
                <span>Обновлен: {{ $list->updated_at->format('d.m.Y') }}</span>
            </div>
        </div>
    </div>
</div>