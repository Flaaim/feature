# Очереди.
### Oueue database
1. В файле .env устанавливаем `QUEUE_CONNECTION=database`.
2. Создаем миграцию и запускаем миграцию.
```
php artisan queue:table
 
php artisan migrate
```
3. Должен быть создан custom `Notifications` смотри [Custom email](https://github.com/Flaaim/feature/blob/main/laravel/auths/reset_password_custom_email.md)
4. Устанавливаем, что класс `CustomNotification implements ShouldQueue`
5. Теперь при отправке email, должна заполниться таблица jobs в базе данных.
