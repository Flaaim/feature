## Отправка данных
### Guzzle
1. Устанавливаем guzzle. `composer require guzzlehttp/guzzle:^7.0`
2. Подключаем автозагрузку и делаем запрос.
```php
  require 'vendor/autoload.php';
  use GuzzleHttp\Client;
  
  $client = new Client();
  $response = $client->get('https://test.ru', []) //GET запрос
  $response = $client->post('https://test.ru', []) //POST запрос
```

## Получение данных

### использую DiDom.
1. Устанавливаем DiDom `composer require imangazaliev/didom`

2. Подключаем пространство имен `use DiDom\Document;`
