# Получаем константы модели.

1. Модель User, имеет 2 константы
```php

//User

const STATUS_ACTIVE = '1';
const STATUS_INACTIVE = '0';
```
2. Пишем функцию для получения констант в модели User
```php
//User
public function getStatusConstant():array
{
  $reflector = new \ReflectionClass($this);
  $constants = $reflector->getConstants();
  $values = [];
  foreach($constants as $key => $value){
    if(Str::contains($key, 'STATUS_')){
      $values[$key] = $value;
    }
  }
  return $values; //возвращает [STATUS_ACTIVE => '1', STATUS_INACTIVE = '0']
}
```
