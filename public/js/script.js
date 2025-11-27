// Основные функции для LifeFlow - Life-контроллера

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initAnimations();
    initAuthState();
    initProgressBars();
    initCardInteractions();
    initFormValidations();
    initCheckboxInteractions();
});

// Анимации при скролле
function initAnimations() {
    const animatedElements = document.querySelectorAll('.feature-card, .step, .stat-card, .benefit-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// Переключение состояния авторизации
function initAuthState() {
    // Имитация состояния авторизации (для демонстрации)
    // В реальном приложении это будет определяться бэкендом
    const isAuthenticated = false; // Измените на true для просмотра авторизованного состояния
    
    const guestButtons = document.getElementById('guest-buttons');
    const userProfile = document.getElementById('user-profile');
    
    if (isAuthenticated) {
        guestButtons.classList.add('hidden');
        userProfile.classList.remove('hidden');
    } else {
        guestButtons.classList.remove('hidden');
        userProfile.classList.add('hidden');
    }
}

// Инициализация интерактивных прогресс-баров
function initProgressBars() {
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const fill = bar.querySelector('.progress-fill');
        if (fill) {
            // Анимируем заполнение прогресс-бара
            const width = fill.style.width;
            fill.style.width = '0';
            setTimeout(() => {
                fill.style.width = width;
            }, 500);
        }
    });
}

// Инициализация взаимодействий с карточками
function initCardInteractions() {
    const cards = document.querySelectorAll('.wishlist-card, .feature-card, .benefit-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (this.classList.contains('feature-card') || this.classList.contains('benefit-card')) {
                this.style.transform = 'translateY(-10px)';
            } else {
                this.style.transform = 'translateY(-5px)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        // Для карточек вишлистов добавляем клик для перехода
        if (card.classList.contains('wishlist-card')) {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('button')) {
                    const cardId = this.dataset.id || '1';
                    window.location.href = `/wishlists/${cardId}`;
                }
            });
        }
    });
}

// Инициализация взаимодействий с чекбоксами
function initCheckboxInteractions() {
    const checkboxes = document.querySelectorAll('.item-checkbox input');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const item = this.closest('.wishlist-item');
            const itemId = item.dataset.itemId || '1';
            
            if (this.checked) {
                item.classList.add('completed');
                toggleWishlistItem(itemId, true);
            } else {
                item.classList.remove('completed');
                toggleWishlistItem(itemId, false);
            }
            
            // Обновляем прогресс вишлиста
            updateWishlistProgress();
        });
    });
}

// Базовая валидация форм
function initFormValidations() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    highlightInvalidField(field);
                } else {
                    removeInvalidHighlight(field);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Пожалуйста, заполните все обязательные поля', 'error');
            }
        });
    });
}

// Подсветка невалидных полей
function highlightInvalidField(field) {
    field.classList.add('invalid-field');
}

// Удаление подсветки невалидных полей
function removeInvalidHighlight(field) {
    field.classList.remove('invalid-field');
}

// Показать уведомление
function showNotification(message, type = 'info') {
    // Создаем элемент уведомления
    const notification = document.createElement('div');
    notification.className = `notification ${type} fade-in`;
    notification.textContent = message;
    
    // Стилизация уведомления
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '1rem 1.5rem';
    notification.style.borderRadius = '8px';
    notification.style.zIndex = '1000';
    notification.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.3)';
    notification.style.fontWeight = '500';
    notification.style.fontFamily = "'Inter', sans-serif";
    
    if (type === 'error') {
        notification.style.background = 'linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)';
    } else if (type === 'success') {
        notification.style.background = 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)';
    } else {
        notification.style.background = 'var(--gradient-primary)';
    }
    
    // Добавляем в DOM
    document.body.appendChild(notification);
    
    // Удаляем через 5 секунд
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Функция для переключения состояния элементов вишлиста
function toggleWishlistItem(itemId, completed) {
    // Здесь будет AJAX запрос к серверу
    console.log(`Toggling item ${itemId} to ${completed}`);
    
    // В реальном приложении здесь будет fetch запрос к API
    // fetch(`/api/wishlist-items/${itemId}`, {
    //     method: 'PUT',
    //     headers: {
    //         'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify({ completed: completed })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     console.log('Success:', data);
    // })
    // .catch((error) => {
    //     console.error('Error:', error);
    // });
}

// Функция для обновления прогресса вишлиста
function updateWishlistProgress() {
    // Здесь будет логика пересчета прогресса
    const items = document.querySelectorAll('.wishlist-item');
    const totalItems = items.length;
    const completedItems = document.querySelectorAll('.wishlist-item.completed').length;
    
    const progressPercentage = totalItems > 0 ? (completedItems / totalItems) * 100 : 0;
    
    // Обновляем прогресс-бар
    const progressFill = document.querySelector('.overall-progress .progress-fill');
    if (progressFill) {
        progressFill.style.width = `${progressPercentage}%`;
    }
    
    // Обновляем текстовое отображение прогресса
    const progressText = document.querySelector('.progress-label span:last-child');
    if (progressText) {
        progressText.textContent = `${completedItems}/${totalItems} (${Math.round(progressPercentage)}%)`;
    }
    
    console.log(`Progress updated: ${completedItems}/${totalItems} (${progressPercentage}%)`);
}

// Функция для создания нового вишлиста
function createWishlist() {
    // В реальном приложении здесь будет форма создания вишлиста
    showNotification('Функция создания вишлиста будет реализована позже', 'info');
}

// Функция для добавления нового элемента в вишлист
function addWishlistItem(form) {
    // В реальном приложении здесь будет отправка формы
    console.log('Adding new wishlist item');
    
    // Показать уведомление об успехе
    showNotification('Элемент успешно добавлен в вишлист', 'success');
    
    // Сбросить форму
    form.reset();
    
    // В реальном приложении здесь будет обновление интерфейса
}

// Добавляем обработчики событий после загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик для кнопки создания вишлиста
    const createButton = document.querySelector('.create-button');
    if (createButton) {
        createButton.addEventListener('click', createWishlist);
    }
    
    // Обработчик для формы добавления элемента
    const addItemForm = document.querySelector('.add-item-form form');
    if (addItemForm) {
        addItemForm.addEventListener('submit', function(e) {
            e.preventDefault();
            addWishlistItem(this);
        });
    }
    
    // Добавляем стили для невалидных полей
    const style = document.createElement('style');
    style.textContent = `
        .invalid-field {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2) !important;
        }
    `;
    document.head.appendChild(style);
});