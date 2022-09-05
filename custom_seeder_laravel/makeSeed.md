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
    if($this->alreadyExists()){
        $this->error('Seed already exists');
    } else {
        $this->makeDirectory($path);
        $stub = $this->files->get(base_path('/resources/stubs/seed.stub'));
        $stub = str_replace(
                [
                    'DummyNamespace',
                    'DummyClass',
                ],
                [
                    'App\\'.$this->input->getOption('path'),
                    $name,
                ],
                $stub
            );
            $this->files->put($path, $stub);
    }
}
```
4. Функция getPath();
```
    private function getPath($name)
    {
        if($this->input->getOption('path')){
            $path = $this->laravel['path'].'\\'.$this->input->getOption('path').'\\'.$name.'.php';
        } else {
           $path = $this->laravel->databasePath().'\\seeders\\'.$name.".php";
        }
        return $path;
    }

```
5. Функция alredyExists();
```php
    private function alreadyExists($path)
    {
        return $this->files->exists($path);
    }
```
6. Функция makeDirectory($path)
```php
    private function makeDirectory($path){
        if(! $this->files->isDirectory(dirname($path))){
            $path = $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
        return $path;
    }

```
7. Filesystem
```php
use Illuminate\Filesystem\Filesystem;

protected $files;

public function __construct(Filesystem $filesystem){
    parent::__construct();
    $this->files = $filesystem;
}
