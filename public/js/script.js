// LifeFlow - Упрощенная и более элегантная версия
class LifeFlow {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.initAnimations();
            this.initAuthState();
            this.initProgressBars();
            this.initCardInteractions();
            this.initFormValidations();
            this.initPageSpecificFeatures();
            this.initNotifications();
        });
    }

    // Анимации при скролле
    initAnimations() {
        const animatedElements = document.querySelectorAll('.feature-card, .step, .stat-card, .benefit-card, .wishlist-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.classList.add('fade-in');
                }
            });
        }, { 
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // Переключение состояния авторизации
    initAuthState() {
        const isAuthenticated = localStorage.getItem('lifeflow_authenticated') === 'true';
        this.updateAuthUI(isAuthenticated);
    }

    updateAuthUI(isAuthenticated) {
        const guestButtons = document.getElementById('guest-buttons');
        const userProfile = document.getElementById('user-profile');

        if (isAuthenticated && guestButtons && userProfile) {
            guestButtons.classList.add('hidden');
            userProfile.classList.remove('hidden');
        } else if (guestButtons && userProfile) {
            guestButtons.classList.remove('hidden');
            userProfile.classList.add('hidden');
        }
    }

    // Инициализация интерактивных прогресс-баров
    initProgressBars() {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const fill = bar.querySelector('.progress-fill');
            if (fill && !fill.dataset.animated) {
                const width = fill.style.width || fill.dataset.width;
                fill.style.width = '0';
                fill.dataset.animated = 'true';
                
                setTimeout(() => {
                    fill.style.width = width;
                }, 500);
            }
        });
    }

    // Инициализация взаимодействий с карточками
    initCardInteractions() {
        const cards = document.querySelectorAll('.wishlist-card, .feature-card, .benefit-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                this.animateCardHover(card, true);
            });

            card.addEventListener('mouseleave', () => {
                this.animateCardHover(card, false);
            });

            // Клик по карточкам вишлистов
            if (card.classList.contains('wishlist-card')) {
                card.addEventListener('click', (e) => {
                    if (!e.target.closest('button') && !e.target.closest('a')) {
                        const cardId = card.dataset.id || '1';
                        window.location.href = `/wishlists/${cardId}`;
                    }
                });
            }
        });
    }

    animateCardHover(card, isHover) {
        if (card.classList.contains('feature-card') || card.classList.contains('benefit-card')) {
            card.style.transform = isHover ? 'translateY(-10px)' : 'translateY(0)';
        } else if (card.classList.contains('wishlist-card')) {
            card.style.transform = isHover ? 'translateY(-10px)' : 'translateY(0)';
        }
    }

    // Базовая валидация форм
    initFormValidations() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            // Пропускаем форму добавления элемента, она обрабатывается отдельно
            if (form.id === 'addItemFormElement') {
                return;
            }
            
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showNotification('Пожалуйста, заполните все обязательные поля', 'error');
                }
            });
        });
    }

    validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                this.highlightInvalidField(field);
            } else {
                this.removeInvalidHighlight(field);
            }
        });

        return isValid;
    }

    highlightInvalidField(field) {
        field.classList.add('invalid-field');
    }

    removeInvalidHighlight(field) {
        field.classList.remove('invalid-field');
    }

    // Инициализация уведомлений
    initNotifications() {
        if (!document.getElementById('notifications-container')) {
            const container = document.createElement('div');
            container.id = 'notifications-container';
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                display: flex;
                flex-direction: column;
                gap: 10px;
            `;
            document.body.appendChild(container);
        }
    }

    // Показать уведомление
    showNotification(message, type = 'info', duration = 5000) {
        const container = document.getElementById('notifications-container') || this.createNotificationsContainer();
        
        const notification = document.createElement('div');
        notification.className = `notification ${type} fade-in`;
        
        const typeIcons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${typeIcons[type] || typeIcons.info}</span>
                <span class="notification-message">${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        `;

        Object.assign(notification.style, {
            background: this.getNotificationColor(type),
            color: 'white',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            boxShadow: '0 10px 25px rgba(0, 0, 0, 0.3)',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            gap: '1rem',
            minWidth: '300px',
            maxWidth: '400px',
            fontFamily: "'Inter', sans-serif",
            fontWeight: '500',
            backdropFilter: 'blur(10px)',
            border: '1px solid rgba(255, 255, 255, 0.1)'
        });

        container.appendChild(notification);

        if (duration > 0) {
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }
            }, duration);
        }

        return notification;
    }

    getNotificationColor(type) {
        const colors = {
            success: 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)',
            error: 'linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)',
            warning: 'linear-gradient(135deg, #d97706 0%, #b45309 100%)',
            info: 'var(--gradient-primary)'
        };
        return colors[type] || colors.info;
    }

    createNotificationsContainer() {
        const container = document.createElement('div');
        container.id = 'notifications-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(container);
        return container;
    }

    // Функции для страницы вишлистов
    initPageSpecificFeatures() {
        if (document.querySelector('.wishlists-grid')) {
            this.initWishlistPage();
        }

        if (document.querySelector('.wishlist-items-section')) {
            this.initWishlistShowPage();
        }

        if (document.querySelector('.hero')) {
            this.initHomePage();
        }
    }

    initHomePage() {
        const ctaButton = document.querySelector('.cta-button');
        if (ctaButton) {
            setTimeout(() => {
                ctaButton.classList.add('pulse');
            }, 2000);
        }
    }

    initWishlistPage() {
        this.initWishlistCardInteractions();
    }

    initWishlistShowPage() {
        // Анимация появления элементов
        const items = document.querySelectorAll('.wishlist-item');
        items.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Обработчик для формы добавления элемента
        const addItemForm = document.getElementById('addItemFormElement');
        if (addItemForm) {
            addItemForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleAddItemForm(addItemForm);
            });
        }

        // Обработчик для формы редактирования элемента
        const editItemForm = document.getElementById('editItemForm');
        if (editItemForm) {
            editItemForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleEditItemForm(editItemForm);
            });
        }
    }

    // НОВЫЙ МЕТОД: Предпросмотр изображения для добавления
    handleImagePreview(input) {
        const preview = document.getElementById('imagePreview');
        const removeButton = document.querySelector('.image-remove-button');
        const placeholder = preview.querySelector('.image-preview-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Удаляем placeholder
                if (placeholder) {
                    placeholder.remove();
                }
                
                // Создаем или обновляем изображение
                let img = preview.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    preview.appendChild(img);
                }
                
                img.src = e.target.result;
                img.alt = 'Предпросмотр изображения';
                img.style.cssText = `
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 12px;
                    display: block;
                `;
                
                // Показываем кнопку удаления
                removeButton.classList.remove('hidden');
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // НОВЫЙ МЕТОД: Предпросмотр изображения для редактирования
    handleEditImagePreview(input) {
        const preview = document.getElementById('editImagePreview');
        const removeButton = input.closest('.image-upload-container').querySelector('.image-remove-button');
        const placeholder = preview.querySelector('.image-preview-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                
                let img = preview.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    preview.appendChild(img);
                }
                
                img.src = e.target.result;
                img.alt = 'Предпросмотр изображения';
                img.style.cssText = `
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 12px;
                    display: block;
                `;
                
                removeButton.classList.remove('hidden');
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // НОВЫЙ МЕТОД: Удаление выбранного изображения для добавления
    removeImage() {
        const input = document.getElementById('image');
        const preview = document.getElementById('imagePreview');
        const removeButton = document.querySelector('.image-remove-button');
        
        // Сбрасываем input file
        input.value = '';
        
        // Удаляем изображение preview
        const img = preview.querySelector('img');
        if (img) {
            img.remove();
        }
        
        // Восстанавливаем placeholder
        if (!preview.querySelector('.image-preview-placeholder')) {
            const placeholder = document.createElement('div');
            placeholder.className = 'image-preview-placeholder';
            placeholder.innerHTML = `
                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                </svg>
                <span>Изображение не выбрано</span>
            `;
            preview.appendChild(placeholder);
        }
        
        // Скрываем кнопку удаления
        removeButton.classList.add('hidden');
    }

    // НОВЫЙ МЕТОД: Удаление выбранного изображения для редактирования
    removeEditImage() {
        const input = document.getElementById('edit_image');
        const preview = document.getElementById('editImagePreview');
        const removeButton = preview.parentElement.querySelector('.image-remove-button');
        const placeholder = preview.querySelector('.image-preview-placeholder');
        
        // Сбрасываем input file
        input.value = '';
        
        // Удаляем изображение preview
        const img = preview.querySelector('img');
        if (img) {
            img.remove();
        }
        
        // Показываем placeholder
        if (placeholder) {
            placeholder.style.display = 'flex';
        }
        
        // Скрываем кнопку удаления
        removeButton.classList.add('hidden');
    }

    // УПРОЩЕННЫЙ МЕТОД: Переключение состояния элемента
    async toggleItemCompletion(checkbox) {
        const completed = checkbox.checked;
        const url = checkbox.dataset.url;
        const itemElement = checkbox.closest('.wishlist-item');

        try {
            // Сразу обновляем UI
            if (completed) {
                itemElement.classList.add('completed');
            } else {
                itemElement.classList.remove('completed');
            }

            // Отправляем запрос к серверу
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ completed: completed })
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.success) {
                if (data.progress) {
                    this.updateWishlistProgress(data.progress);
                }
                this.showNotification('Статус записи обновлен', 'success');
            } else {
                // Откатываем изменения при ошибке
                checkbox.checked = !completed;
                if (completed) {
                    itemElement.classList.remove('completed');
                } else {
                    itemElement.classList.add('completed');
                }
                throw new Error(data.message);
            }

        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Ошибка при обновлении статуса', 'error');
        }
    }

    // УПРОЩЕННЫЙ МЕТОД: Удаление элемента
    async deleteItem(button) {
        const url = button.dataset.url;
        const itemElement = button.closest('.wishlist-item');

        if (!confirm('Вы уверены, что хотите удалить эту запись?')) {
            return;
        }

        try {
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.success) {
                // Анимация удаления
                itemElement.style.opacity = '0';
                itemElement.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    itemElement.remove();
                    // Обновляем прогресс
                    if (data.progress) {
                        this.updateWishlistProgress(data.progress);
                    }
                    // Обновляем счетчик элементов
                    this.updateItemsCount();
                }, 300);

                this.showNotification('Запись успешно удалена', 'success');

                // Если записей не осталось, показываем empty state
                if (document.querySelectorAll('.wishlist-item').length === 0) {
                    this.showEmptyState();
                }
            } else {
                throw new Error(data.message);
            }

        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Ошибка при удалении записи', 'error');
        }
    }

    // НОВЫЙ МЕТОД: Редактирование элемента
    async editItem(itemId) {
        try {
            // Получаем данные элемента через AJAX
            const response = await fetch(`/wishlist-items/${itemId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const item = await response.json();

            // Заполняем форму редактирования данными элемента
            this.fillEditForm(item);
            
            // Показываем модальное окно
            this.showEditModal();

        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Ошибка при загрузке данных записи', 'error');
        }
    }

    // НОВЫЙ МЕТОД: Заполнение формы редактирования
    fillEditForm(item) {
        document.getElementById('edit_title').value = item.title;
        document.getElementById('edit_description').value = item.description || '';
        document.getElementById('edit_price').value = item.price || '';
        document.getElementById('edit_url').value = item.url || '';

        // Устанавливаем action формы
        const form = document.getElementById('editItemForm');
        form.action = `/wishlist-items/${item.id}`;

        // Обработка изображения
        const preview = document.getElementById('editImagePreview');
        const removeButton = preview.parentElement.querySelector('.image-remove-button');
        const placeholder = preview.querySelector('.image-preview-placeholder');

        if (item.image_url) {
            // Если есть изображение, показываем его
            if (placeholder) placeholder.style.display = 'none';
            let img = preview.querySelector('img');
            if (!img) {
                img = document.createElement('img');
                preview.appendChild(img);
            }
            img.src = item.image_url;
            img.alt = 'Предпросмотр изображения';
            img.style.cssText = `
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 12px;
                display: block;
            `;
            removeButton.classList.remove('hidden');
        } else {
            // Если изображения нет, показываем плейсхолдер
            if (placeholder) placeholder.style.display = 'flex';
            const img = preview.querySelector('img');
            if (img) img.remove();
            removeButton.classList.add('hidden');
        }
    }

    // НОВЫЙ МЕТОД: Показать модальное окно редактирования
    showEditModal() {
        const modal = document.getElementById('editItemModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            
            // Анимация появления
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                modal.style.opacity = '1';
                modal.style.transform = 'scale(1)';
            }, 10);
        }
    }

    // НОВЫЙ МЕТОД: Скрыть модальное окно редактирования
    hideEditModal() {
        const modal = document.getElementById('editItemModal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }, 300);
        }
    }

    // НОВЫЙ МЕТОД: Обработка формы редактирования
    async handleEditItemForm(form) {
        const formData = new FormData(form);
        
        // Валидация обязательных полей
        if (!this.validateForm(form)) {
            this.showNotification('Пожалуйста, заполните все обязательные поля', 'error');
            return;
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST', // потому что мы используем @method('PUT') в форме
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.success) {
                this.showNotification('Запись успешно обновлена', 'success');
                this.hideEditModal();
                
                // Обновляем данные на странице
                this.updateItemInList(data.item);
                
                // Обновляем прогресс, если он изменился
                if (data.progress) {
                    this.updateWishlistProgress(data.progress);
                }
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Ошибка при обновлении записи', 'error');
        }
    }

    // НОВЫЙ МЕТОД: Обновление элемента в списке
    updateItemInList(updatedItem) {
        const itemElement = document.querySelector(`.wishlist-item[data-item-id="${updatedItem.id}"]`);
        if (!itemElement) return;

        // Обновляем содержимое элемента
        const titleElement = itemElement.querySelector('.item-title');
        const descriptionElement = itemElement.querySelector('.item-description');
        const priceElement = itemElement.querySelector('.item-price');
        const linkElement = itemElement.querySelector('.item-link');
        const imageElement = itemElement.querySelector('.item-image img');
        const placeholderElement = itemElement.querySelector('.item-image-placeholder');

        if (titleElement) titleElement.textContent = updatedItem.title;
        if (descriptionElement) descriptionElement.textContent = updatedItem.description || '';
        if (priceElement) {
            if (updatedItem.price) {
                priceElement.textContent = `${Number(updatedItem.price).toLocaleString('ru-RU')} ₽`;
                priceElement.style.display = 'inline';
            } else {
                priceElement.style.display = 'none';
            }
        }
        if (linkElement) {
            if (updatedItem.url) {
                linkElement.href = updatedItem.url;
                linkElement.style.display = 'flex';
            } else {
                linkElement.style.display = 'none';
            }
        }

        // Обновляем изображение
        if (updatedItem.image_url) {
            if (imageElement) {
                imageElement.src = updatedItem.image_url;
                imageElement.style.display = 'block';
            } else {
                // Создаем изображение, если его нет
                const newImage = document.createElement('img');
                newImage.src = updatedItem.image_url;
                newImage.alt = updatedItem.title;
                newImage.style.cssText = `
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 12px;
                `;
                const imageContainer = itemElement.querySelector('.item-image');
                if (imageContainer) {
                    if (placeholderElement) placeholderElement.style.display = 'none';
                    imageContainer.appendChild(newImage);
                }
            }
        } else {
            // Если изображения нет, показываем плейсхолдер
            if (imageElement) {
                imageElement.remove();
            }
            if (placeholderElement) {
                placeholderElement.style.display = 'flex';
            }
        }
    }

    // ИСПРАВЛЕННЫЙ МЕТОД: Обработка добавления элемента с изображением
    async handleAddItemForm(form) {
        const formData = new FormData(form);
        
        // Валидация обязательных полей
        if (!this.validateForm(form)) {
            this.showNotification('Пожалуйста, заполните все обязательные поля', 'error');
            return;
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.success) {
                this.showNotification('Запись успешно добавлена', 'success');
                
                // Обновляем страницу вместо динамического добавления
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Ошибка при добавлении записи', 'error');
        }
    }

    // Обновление прогресса вишлиста
    updateWishlistProgress(progress) {
        if (progress) {
            const progressFill = document.querySelector('.overall-progress .progress-fill');
            const progressStats = document.querySelector('.progress-stats');
            
            if (progressFill && progress.percentage !== undefined) {
                progressFill.style.width = `${progress.percentage}%`;
            }
            
            if (progressStats && progress.completed !== undefined && progress.total !== undefined) {
                progressStats.textContent = `${progress.completed}/${progress.total} (${progress.percentage || 0}%)`;
            }
        }
    }

    createWishlist() {
        this.showNotification('Функция создания вишлиста будет реализована позже', 'info');
    }
}

// Инициализация приложения
const lifeFlow = new LifeFlow();

// Глобальные функции для использования в HTML
window.showAddItemForm = () => {
    const form = document.getElementById('addItemForm');
    if (form) {
        form.classList.remove('hidden');
        form.style.display = 'block';
        const titleInput = document.getElementById('title');
        if (titleInput) titleInput.focus();
        
        form.style.opacity = '0';
        form.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            form.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 10);
    }
};

window.hideAddItemForm = () => {
    const form = document.getElementById('addItemForm');
    if (form) {
        form.style.opacity = '0';
        form.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            form.classList.add('hidden');
            form.style.display = 'none';
        }, 300);
    }
};