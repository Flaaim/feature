# Экспорт таблицы в эксель.
1. Устанавливаем пакет maatwebsite/excel. composer require maatwebsite/excel;
2. Прописываем Providers и Aliases
3. Создаем export file. php artisan make:export DirectionsExport; Добавляем к классу WithHeadings, для создания шапки будущей таблицы
```php
    use Maatwebsite\Excel\Concerns\WithHeadings;
    class DirectionsExport implements FromCollection, WithHeadings 
    {
     ///
    }
```
5. Добавляем метод headings(). Данный метод возвращает массив, который будет шапкой эксель таблицы.
```php

public function headings():array
    {
        return [
            '№ направления',
            'Дата выдачи',
            'Вид направления',
            'Фамилия Имя Отчество',
            'Наименование должности (профессии) или вида работы',
            'Пол',
            'Структурное подразделение',
            'Вредные и (или) опасные производственные факторы. Вид работы',
        ];
    }
```
6. Создаем переменную $company
```php
    protected $company;

    public function __construct($company){
        $this->company = $company;
    }
```
8. Описываем метод collection()
```php
  public function collection()
  {
    $directions = $this->getDirections();
            return $directions->map(function($item){
            return [
                $item->number,
                $item->date,
                $item->typeOfDirection,
                $item->fullname,
                $item->profession,
                $item->gender,
                $item->department,
                $item->factors,
            ];
        });
    
  }
```
7. Описываем метод getDirections()
```php
    public function getDirections(){
        return $this->company->directions()->get();
    }
```
9. В контроллере создаем метод export();
```php
  /SomeController
  public function export($company)
  {
    $directions = new DirectionExport($company)
  }
  ```
  10. Прописываем route
  ```php
              Route::get('/export/{company}', [App\Http\Controllers\DirectionController::class, 'export'])->name('direction.export');
  ```
