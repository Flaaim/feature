## custom Seeder
> Seeder c возможностью создавать Seed в директории App, если указан флаг --path=.
1. Создаем команду для формирования seeder'a. php artisan make:command MakeSeeder
2. В созданном файле MakeSeeder.php описываем функцию signature
```php
    protected $signature = 'make:seed {name} {--path=}'
```
3. Описываем функцию handle()
```
public function handle()
{
    $name = Str::studly($this->argument('name'));
    $path = $this->getPath($name);
}
```
4. Функция getPath();
```
    private function getPath($name)
    {
    
    }

```
