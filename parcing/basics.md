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
3. Добавляем cookie. 
```php
use GuzzleHttp\Cookie\CookieJar;
$jar = new CookieJar();
$cookies = [
    'Kodeks' => '1674004423',
    'Auth' => 'UlJDMTI3VTE6U3lKTXhqNw==',
    'lastVDir' => '%2Fdocs',
    'KodeksData'=> 'XzE2Nzc3MzQzXzE3OTMyMDU=',
    'state' => 'state',
]; //формируем массив cookie.

$cookieJar = $jar->fromArray($cookies, 'https://test.ru');
$response = $client->get('https://test.ru', [
  'cookies' => $cookieJar
]);

```
## Получение данных

### используем DiDom.
1. Устанавливаем DiDom `composer require imangazaliev/didom`

2. Подключаем пространство имен `use DiDom\Document;`
3. Получаем данные:
```php
$links = $document->find('tagname.class');
```
