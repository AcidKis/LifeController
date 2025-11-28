@extends('layouts.app')

@section('title', 'LifeFlow - Ваш личный организатор')

@section('content')
<!-- Герой секция -->

<div class="hero">
    <div class="container">
        <div class="hero-content fade-in">
            <h1>Организуйте свою жизнь <span class="accent">с умом</span></h1>
            <p>От желаний до воспоминаний - все важные моменты вашей жизни в одном приложении. Создавайте, планируйте и сохраняйте.</p>

            <div class="hero-stats">
                <div class="stat-card fade-in">
                    <span class="number">25K+</span>
                    <p>Активных пользователей</p>
                </div>
                <div class="stat-card fade-in">
                    <span class="number">150K+</span>
                    <p>Созданных целей</p>
                </div>
                <div class="stat-card fade-in">
                    <span class="number">500K+</span>
                    <p>Сохраненных воспоминаний</p>
                </div>
            </div>

            <a href="/register" class="cta-button">Начать бесплатно</a>
        </div>
    </div>
</div>

<!-- Секция возможностей -->
<div class="features">
    <div class="container">
        <div class="section-header fade-in">
            <h2>Все для организации вашей жизни</h2>
            <p>Откройте для себя полный набор инструментов для управления вашими желаниями, целями и воспоминаниями</p>
        </div>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <svg class="feature-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z" fill="currentColor" />
                </svg>
                <h3>Списки желаний</h3>
                <p>Создавайте и организуйте ваши желания и цели. Отмечайте прогресс и празднуйте достижения.</p>
                <ul class="feature-list">
                    <li>Персональные и общие списки</li>
                    <li>Отслеживание прогресса выполнения</li>
                    <li>Напоминания и дедлайны</li>
                    <li>Приоритизация задач</li>
                </ul>
            </div>

            <div class="feature-card fade-in">
                <svg class="feature-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 3H18V1H16V3H8V1H6V3H5C3.89 3 3.01 3.9 3.01 5L3 19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V8H19V19Z" fill="currentColor" />
                    <path d="M7 10H12V15H7V10Z" fill="currentColor" />
                </svg>
                <h3>Умный календарь</h3>
                <p>Планируйте события, встречи и важные даты. Никогда не пропускайте ничего значимого.</p>
                <ul class="feature-list">
                    <li>Интеграция с внешними календарями</li>
                    <li>Напоминания о событиях</li>
                    <li>Повторяющиеся события</li>
                    <li>Цветовое кодирование</li>
                </ul>
            </div>

            <div class="feature-card fade-in">
                <svg class="feature-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6C4.9 2 4.01 2.9 4.01 4L4 20C4 21.1 4.89 22 5.99 22H18C19.1 22 20 21.1 20 20V8L14 2ZM18 20H6V4H13V9H18V20Z" fill="currentColor" />
                </svg>
                <h3>Планирование целей</h3>
                <p>Ставьте цели, разбивайте их на этапы и отслеживайте прогресс на пути к их достижению.</p>
                <ul class="feature-list">
                    <li>SMART-цели</li>
                    <li>Разбивка на подзадачи</li>
                    <li>Визуализация прогресса</li>
                    <li>Мотивационные напоминания</li>
                </ul>
            </div>

            <div class="feature-card fade-in">
                <svg class="feature-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="currentColor" />
                </svg>
                <h3>Дневник воспоминаний</h3>
                <p>Сохраняйте самые важные моменты вашей жизни в организованном и красивом виде.</p>
                <ul class="feature-list">
                    <li>Фото и видео галерея</li>
                    <li>Текстовые заметки</li>
                    <li>Хронология событий</li>
                    <li>Приватный доступ</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Секция преимуществ -->
<div class="benefits">
    <div class="container">
        <div class="section-header fade-in">
            <h2>Почему выбирают LifeFlow</h2>
            <p>Уникальные возможности, которые делают организацию жизни простой и приятной</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-card fade-in">
                <svg class="benefit-icon" width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="currentColor" />
                    <path d="M12.5 7H11V13L16.2 16.2L17 15L12.5 12.2V7Z" fill="currentColor" />
                </svg>
                <h3>Экономия времени</h3>
                <p>Все инструменты в одном месте избавляют от необходимости переключаться между приложениями</p>
            </div>

            <div class="benefit-card fade-in">
                <svg class="benefit-icon" width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12L11 14L15 10M12 3C13.1819 3 14.3522 3.23279 15.4442 3.68508C16.5361 4.13738 17.5282 4.80031 18.364 5.63604C19.1997 6.47177 19.8626 7.46392 20.3149 8.55585C20.7672 9.64778 21 10.8181 21 12C21 13.1819 20.7672 14.3522 20.3149 15.4442C19.8626 16.5361 19.1997 17.5282 18.364 18.364C17.5282 19.1997 16.5361 19.8626 15.4442 20.3149C14.3522 20.7672 13.1819 21 12 21C10.8181 21 9.64778 20.7672 8.55585 20.3149C7.46392 19.8626 6.47177 19.1997 5.63604 18.364C4.80031 17.5282 4.13738 16.5361 3.68508 15.4442C3.23279 14.3522 3 13.1819 3 12C3 9.61305 3.94821 7.32387 5.63604 5.63604C7.32387 3.94821 9.61305 3 12 3Z" fill="currentColor" />
                </svg>
                <h3>Достижение целей</h3>
                <p>Система отслеживания прогресса помогает не сбиваться с пути и достигать поставленных целей</p>
            </div>

            <div class="benefit-card fade-in">
                <svg class="benefit-icon" width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor" />
                    <path d="M19 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V6C21 4.89543 20.1046 4 19 4Z" fill="currentColor" />
                </svg>
                <h3>Визуализация</h3>
                <p>Красивый и интуитивный интерфейс помогает видеть общую картину вашей жизни</p>
            </div>
        </div>
    </div>
</div>

<!-- Секция как это работает -->
<div class="how-it-works">
    <div class="container">
        <div class="section-header fade-in">
            <h2>Начните за 3 простых шага</h2>
            <p>Быстрый старт и мгновенные результаты - организация жизни никогда не была такой простой</p>
        </div>

        <div class="steps">
            <div class="step fade-in">
                <div class="step-number">1</div>
                <h3>Создайте аккаунт</h3>
                <p>Зарегистрируйтесь и настройте ваш профиль. Это займет всего пару минут.</p>
            </div>
            <div class="step fade-in">
                <div class="step-number">2</div>
                <h3>Добавьте ваши цели</h3>
                <p>Создайте списки желаний, планы и добавьте важные даты в календарь.</p>
            </div>
            <div class="step fade-in">
                <div class="step-number">3</div>
                <h3>Наслаждайтесь результатом</h3>
                <p>Отслеживайте прогресс, создавайте воспоминания и организуйте свою жизнь.</p>
            </div>
        </div>
    </div>
</div>

<!-- Секция призыва к действию -->
<div class="cta-section">
    <div class="container">
        <h2 class="fade-in">Готовы организовать свою жизнь?</h2>
        <p class="fade-in">Присоединяйтесь к тысячам пользователей, которые уже используют LifeFlow для управления своими желаниями, целями и воспоминаниями</p>
        <a href="/register" class="cta-button">Создать аккаунт бесплатно</a>
    </div>
</div>

@endsection