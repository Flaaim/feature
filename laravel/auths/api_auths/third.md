## Установка laravel Passport
1. Устанавливаем пакет laravel passport. composer require laravel/passport
2. В config/app.php прописываем провайдер паспорта
```php
  Laravel\Passport\PassportServiceProvider::class,
```
3. Запускаем миграцию php artisan migrate
4. Устанавиваем passport php artisan passport:install
5. В config/auth.php добавляем guard 'api' 
```php
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
```
