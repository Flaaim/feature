<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Str;
use Illuminate\Filesystem\Filesystem;

class makeSeed extends Command
{

    protected $files;

    public function __construct(Filesystem $filesystem){
        parent::__construct();
        $this->files = $filesystem;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:seed {name}{--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom seeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = Str::studly(trim($this->argument('name')));
        $path = $this->getPath($name);
        if($this->alreadyExists($path)){
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

    private function getPath($name){
        if($this->input->getOption('path')){
            $path = $this->laravel['path'].'\\'.$this->input->getOption('path').'\\'.$name.'.php';
        
        } else {
            $path = $this->laravel->databasePath().'\\seeders\\'.$name.".php";
        }
        return $path;
    }

    private function alreadyExists($path){
        return $this->files->exists($path);
    }

    private function makeDirectory($path){
        if(! $this->files->isDirectory(dirname($path))){
            $path = $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
        return $path;
    }
}
