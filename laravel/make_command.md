# Создание команды
1. Прописываем php artisan make:command NameofCommmand. Описываем свойство $signature = verify:user {email} 
2. Метод handle вызывается при выполнении команды.
```php
//доступ к аргументы в handle
$this->argument('email')
