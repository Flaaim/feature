# Импорт эксель таблицы в базу данных
1. устанавливаем maatwebsite/excel
```php
composer require maatwebsite/excel
```
2. Создаем модель, миграцию базы данных. В модели определяем свой-во $fillable; 
3. Создаем класс импорт
```php
  php artisan make:import ModelImport // Model - название модели
```
4. Допиливаем класс импорт
```php
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use App\Models\Model;
...

class HarmfulfactorsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Model([
            'profession' => $row['profession'],
            'harmfulfactor' => $row['harmfulfactor'],
            'company_id' => $row['company_id']
        ]);
    }
}
```
5. Определяем контроллер
```php


```
