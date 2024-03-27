<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Pluralizer;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositoryInterface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function singleClassName($name){
        return ucwords(Pluralizer::singular($name));
    }
  
    public function handle()
    {

        $name = $this->singleClassName($this->argument('name'));
        $interfacesDir = app_path("Repositories/Interfaces");

        if (!File::exists($interfacesDir)) {
            File::makeDirectory($interfacesDir, 0777, true);
        }

        $repositoryInterfaceTemplate = <<<EOT
        <?php
        
        namespace App\Repositories\Interfaces;
        
        interface {$name}RepositoryInterface
        {
            public function all();
        
            public function dataTable(array \$attributes);
        
            public function find(\$hashId);
        
            public function store(array \$attributes);
        
            public function update(array \$attributes, \$hashId);
        
            public function delete(\$hashId);
        
            public function changeStatus(\$hashId);
        
        }
        EOT;

        File::put("{$interfacesDir}/{$name}RepositoryInterface.php", $repositoryInterfaceTemplate);
        $this->info("Repository interface created successfully.");

    }
}
