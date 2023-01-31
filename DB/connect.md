# PDO
// Создание соединения
```php
  $dbh = new \PDO('mysql:host=192.168.56.56;dbname=parce','homestead', 'secret'); //пример
```
// Добавление данных
```php
$sql = "INSERT INTO users (name, surname, sex) VALUES (?,?,?)";
$stmt= $pdo->prepare($sql);
$stmt->execute([$name, $surname, $sex]);
```
