# Установка Webhook.
1. Регистрируем бота в BotFather.
2. Формируем url для установки hook
```
https://api.telegram.org/bot[token]/setWebhook?url=
```
3. На сервере создаем файл index.php
```
//index.php


require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/ErrorHandler.php';

$token = '.....';

use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

$telegram = new Api($token);
$update = $telegram->getWebhookUpdates();
new ErrorHandler();
file_put_contents(__DIR__.'/log.txt', print_r($update, 1), FILE_APPEND);
```
