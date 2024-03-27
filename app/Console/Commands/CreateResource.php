<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\GroupPermissionRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class CreateResource extends Command
{
    protected $signature = 'create:resource {name}  {--SI|simpleModal}';

    protected $description = 'Create a model, a controller, a migration, a repository, a repository interface , a Service and a request for the given resource.';

    public function singleClassName($name){
      return ucwords(Pluralizer::singular($name));
    }

    public function handle()
    {


            
            $name = $this->singleClassName($this->argument('name'));
            // $module = strtolower($this->argument('module'));
            $lowerName =  strtolower($name);
            $blade_path = str_replace("/", "",  env('_BLADE_PATH'));
            $js_path =  env('_JS_PATH');
            $main_layout = str_replace("/", ".",  env('_MAIN_LAYOUT'));
            $controller_path =  env('_CONTROLLER_PATH');
            $hasSimpleModal= $this->option('simpleModal');

           

            Artisan::call('make:observer '.$name.'Observer --model='.$name);

            $observerImport = 'use App\Observers\\' . $name . 'Observer;';

            $modelTemplate = <<<EOT
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
{$observerImport}

class {$name} extends Model
{
    use SoftDeletes;

    protected \$fillable = [
        // Specify your fillable fields here...
    ];

   

    /**
     * Eager load with every debt.
     */

    protected \$with = [
       // Eager load
    ];

    protected \$hidden = [
        'deleted_at'
    ];

    public static function booted()
    {
        static::observe(new {$name}Observer());
    }

    /**
     * Relationships
     */

        // RELATIONSHIPS HERE

    /**
     * Methods
     */

       // Methods HERE
}
EOT;




            $modelDir = app_path("Models");

            if (!File::exists($modelDir)) {
                File::makeDirectory($modelDir, 0777, true);
            }

            File::put("{$modelDir}/{$name}.php", $modelTemplate);
            $this->info("Model for {$name} created successfully.");


            $tableName =  Str::snake($name) . 's';


            Artisan::call('make:migration create_'.$tableName.'_table --table='.$tableName);
            $this->info("Migration for {$tableName} created successfully.");



            Artisan::call('make:request', ['name' => "{$name}Request"]);
            $this->info("Request for {$name} created successfully.");

            // Create the repository and repository interface
            $repositoryDir = app_path("Repositories");

            if (!File::exists($repositoryDir)) {
                File::makeDirectory($repositoryDir, 0777, true);
            }



            $repositoryTemplate = <<<EOT
<?php

namespace App\Repositories;

use App\Http\Requests\\{$name}Request;
use App\Models\\{$name};
use App\Repositories\Interfaces\\{$name}RepositoryInterface;

class {$name}Repository implements {$name}RepositoryInterface
{
    private \${$lowerName};

    public function __construct({$name} \${$lowerName})
    {
        \$this->{$lowerName} = \${$lowerName};
    }

    public function all()
    {
        return \$this->{$lowerName}->all();
    }

    public function dataTable(array \$attributes)
    {
        \$data = \$this->{$lowerName}->orderBy('id', 'DESC');

        return datatables()->of(\$data)
        ->filter(function (\$data) use (\$attributes) {

        })
       
        ->addIndexColumn()
        ->rawColumns()->toJson();

    }

    public function find(\$Id)
    {
        return \$this->{$lowerName}->find(\$Id);
    }

    public function store(array \$attributes)
    {
        {$name}::create(\$attributes);
    }

    public function update(array \$attributes, \$Id)
    {
        \$item = \$this->find(\$Id);
        \$item->update(\$attributes);
    }

    function delete(\$Id)
    {
        \${$lowerName} = \$this->find(\$Id);

        return \${$lowerName}->delete();

    }
    function changeStatus(\$Id)
    {
        \${$lowerName} = \$this->find(\$Id);
    }
}
EOT;

          File::put("{$repositoryDir}/{$name}Repository.php", $repositoryTemplate);
          $this->info("{$name}Repository created successfully.");
    // The path to the BackendServiceProvider file
    $backendServiceProviderPath = app_path('Repositories/ServiceProvider/BackendServiceProvider.php');

    // The code to append
    $codeToAppend = "\n\t\t" . '$this->app->bind(' . PHP_EOL;
    $codeToAppend .= "\t\t\t" . '\\App\\Repositories\\Interfaces\\'.$name.'RepositoryInterface::class,' . PHP_EOL;
    $codeToAppend .= "\t\t\t" . '\\App\\Repositories\\'.$name.'Repository::class' . PHP_EOL;
    $codeToAppend .= "\t\t" . ');' . PHP_EOL;

    // Read the contents of the BackendServiceProvider file
    $contents = file_get_contents($backendServiceProviderPath);

    // Find the position of the "public function register()" opening brace
    $position = strpos($contents, "public function register(){",0);

    if ($position !== false) {
        // Insert the code inside the "register()" method at the appropriate position
        $modifiedContents = substr_replace($contents, $codeToAppend, $position + strlen('public function register(){'), 0);

        // Write the modified contents back to the file
        file_put_contents($backendServiceProviderPath, $modifiedContents);

        $this->info('Code has been appended successfully.');
    } else {
        $this->error('The "public function register()" method not found in the file.');
    }



        Artisan::call('make:repositoryInterface', ['name' => "{$name}"]);



            $controllerName = "{$name}Controller";
            $controller_namespace = rtrim(str_replace("/", "\\",'_CONTROLLER_PATH'), "\\");
            $controllerTemplate = <<<EOT
<?php

namespace App\\{$controller_namespace};

use App\Http\Controllers\Controller;
use App\Http\Requests\\{$name}Request;
use App\Repositories\Interfaces\\{$name}RepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Helpers\MainHelper;
use Illuminate\Support\Facades\DB;

class {$controllerName} extends Controller
{
    use ResponseTrait;

    protected \${$lowerName}Repository;


    /**
     * array `functions` to classification of functions
     *
     * @var array
     */
    protected \$functions = [
        'GET' => [
            'index' => [
                'permission' => '{$lowerName}.index',
                'parameters' => [],
            ],
            'dataTable' => [
                'permission' => '{$lowerName}.index',
                'parameters' => ['request'],
            ],
            'create' => [
                'permission' => '{$lowerName}.create',
                'parameters' => [],
            ],
            'edit' => [
                'permission' => '{$lowerName}.edit',
                'parameters' => ['hashId'],
            ],
            'show' => [
                'permission' => '{$lowerName}.show',
                'parameters' => ['hashId'],
            ],
        ],
        'POST' => [
            'store' => [
                'permission' => '{$lowerName}.create',
                'parameters' => ['{$name}Request'],
            ],
            'update' => [
                'permission' => '{$lowerName}.edit',
                'parameters' => ['{$name}Request','hashId'],
            ],
            'destroy' => [
                'permission' => '{$lowerName}.delete',
                'parameters' => ['hashId'],
            ],
            'changeStatus' => [
                'permission' => '{$lowerName}.changeStatus',
                'parameters' => ['hashId'],
            ],
        ],
    ];

    public function __invoke(Request \$request, \$controllerFunction = "index",\$hashId = null)
    {
        \$method = \$request->method();

        if (isset(\$this->functions[\$method][\$controllerFunction])) {
            \$permission = \$this->functions[\$method][\$controllerFunction]['permission'];
            if(\$permission){
                if (auth()->check() && !userHasPermissions(\$permission)) {
                    return response()->json(['error' => 'Function is not found or unauthorized'], 404);
              }
            }

            \$parameters = \$this->functions[\$method][\$controllerFunction]['parameters'];

            if (!empty(\$parameters)) {
                \$params = [];
                foreach (\$parameters as \$param) {
                    if (\$param === '{$name}Request') {
                        \$params[] = app()->make({$name}Request::class);
                    }
                    elseif (\$param === 'request') {
                        \$params[] = \$request;
                    } elseif (\$param === 'hashId') {
                        \$params[] = \$hashId;
                    } else {
                        \$params[] = \$request->input(\$param);
                    }
                }
                return \$this->\$controllerFunction(...\$params);
            }

            return \$this->\$controllerFunction();

        }

        return response()->json(['error' => 'Function is not found or unauthorized'], 404);
    }


    public function __construct({$name}RepositoryInterface \${$lowerName}Repository)
    {
        \$this->{$lowerName}Repository = \${$lowerName}Repository;
    }

    public function index()
    {
        return view('{$blade_path}.{$lowerName}.index');
    }

    public function dataTable(Request \$request)
    {
        return \$this->{$lowerName}Repository->dataTable(\$request->all());
    }

    public function create()
    {
        \$data =  [
            'form_id' => '{$lowerName}-createForm',
            'button_class' => 'submit{$name}-btn',
            'modal_id' => 'create-{$lowerName}-mdl',
            'modal_title' => 'عنون المودل',
            'success_message' => 'رسالة نجاح العملية',
            'button_title' => "save",
            'validation' => \$this->getValidation(new {$name}Request())

        ];
        \$view =  view()->make('{$blade_path}.{$lowerName}.modal', \$data)->render();

        return \$this->generalResponse('TRUE','200','SUCCESS', 'HTML',\$view);

    }

    public function store({$name}Request \$request)
    {

        try {
            DB::transaction(function () use (\$request) {
                \$this->{$lowerName}Repository->store(\$request->validated());
            });
            return \$this->generalResponse(true, 200, "SUCCESS", []);

        } catch (\Exception \$e) {
            return \$e;

            return \$this->generalResponse(false, 422, "fail_m", []);
        }

    }

    public function show(\$Id)
    {
        \$data = \$this->{$lowerName}Repository->find(\$Id);
        return view('{$blade_path}.{$lowerName}.show', compact('data'));
    }

    public function edit(\$hashId)
    {
    \$item = \$this->{$lowerName}Repository->find(\$hashId);

        \$data = [
            'form_id' => '{$lowerName}-editForm',
            'button_class' => 'update{$name}-btn',
            'modal_id' => 'edit-{$lowerName}-mdl',
            'modal_title' => ' ',
            'success_message' => ' ',
            'button_title' => "save",
            'item' => \$item,
            'validation' => \$this->getValidation(new {$name}Request())

        ];

        \$view =  view()->make('{$blade_path}.{$lowerName}.modal', \$data)->render();

        return \$this->generalResponse('TRUE','200','SUCCESS', 'HTML',\$view);
    }

    public function update({$name}Request \$request, \$Id)
    {
        try {
            DB::transaction(function () use (\$Id, \$request) {
            \$this->{$lowerName}Repository->update(\$request->validated(), \$Id);
        });

        return \$this->generalResponse(true, 200, "SUCCESS", []);
        } catch (\Exception \$e) {
             
            return \$e;

            return \$this->generalResponse(false, 500, "failed", []);
        }

    }

    public function destroy(\$Id)
    {
        \${$lowerName}Destroy = \$this->{$lowerName}Repository->delete(\$Id);

        if (\${$lowerName}Destroy)
            return \$this->generalResponse(true, 200, "SUCCESS" , []);
        return \$this->generalResponse(false, 422,"fail_m"  , []);
    }

    public function changeStatus(\$Id)
    {
        return \$this->{$lowerName}Repository->changeStatus(\$Id);
    }
}
EOT;

            $controllerTemplate = str_replace(
                ['return view(\'{$lowerName}.create\');', 'return view(\'{$lowerName}.edit\', compact(\'data\'));'],
                ['return \$this->repository->modal_create();', 'return \$this->repository->modal_update();'],
                $controllerTemplate
            );


            File::put(app_path($controller_path . "$controllerName.php"), $controllerTemplate);
            $this->info("{$controllerName} created successfully.");

    

            $routesDir = base_path("routes");
            $controller_path_name = str_replace("/", "\\", env('_CONTROLLER_PATH')) . $name . "Controller";

            $routesTemplate = <<<EOT

Route::match(['post', 'get'],'{$lowerName}/{controllerFunction?}/{Id?}',App\\{$controller_path_name}::class)->name('{$lowerName}');

EOT;
$modelNameLower = strtolower($this->argument('module')) != 'main' ? strtolower($this->argument('module')) : 'web';
            File::append("{$routesDir}/{$modelNameLower}.php", $routesTemplate);
            $this->info("Routes for {$name} added successfully.");
        }


        

}
