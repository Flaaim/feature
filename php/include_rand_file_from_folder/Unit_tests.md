# Unit tests.
## Установка
1. Устанавливаем в проект PHPUnit. `composer require --dev phpunit/phpunit ^9.5`
2. В директории проекта создаем папку `tests`
3. В composer.json прописываем автозагрузку
```json
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
```
4. Создаем файл для теститрования
```php
//RouteTest.php
<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testTrue(): void
    {
        $this->assertTrue(true);
    }
}
```
## Запуск тестов.
1. Для запуска тестов используем путь к исполняемому файлу phpunit `vendor/bin/phpunit <путь/к/файлу/c/тестами>`
2. Например для того чтобы выполнить тестирование файла RouteTest, находящегося в директории tests, необходимо выполнить `vendor/bin/phpunit tests/RouteTest.php`
