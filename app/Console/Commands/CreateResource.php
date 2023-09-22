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
    protected $signature = 'create:resource {name} --{module} {--SI|simpleModal}';

    protected $description = 'Create a model, a controller, a migration, views, a JS file, a repository, a repository interface , a Service and a request for the given resource.';

    public function singleClassName($name){
      return ucwords(Pluralizer::singular($name));
    }

    public function handle()
    {


            
            $name = $this->singleClassName($this->argument('name'));
            $module = strtolower($this->argument('module'));
            $lowerName =  strtolower($name);
            $blade_path = str_replace("/", "",  env(strtolower($this->argument('module')).'_BLADE_PATH'));
            $js_path =  env(strtolower($this->argument('module')).'_JS_PATH');
            $main_layout = str_replace("/", ".",  env(strtolower($this->argument('module')).'_MAIN_LAYOUT'));
            $controller_path =  env(strtolower($this->argument('module')).'_CONTROLLER_PATH');
            $hasSimpleModal= $this->option('simpleModal');

            app()->make(GroupPermissionRepositoryInterface::class)->store([
                "module_type" => $module,
                "group_ar" => $lowerName,
                "group_en" => $lowerName,
                "permission" => '["index","create","edit","delete","show"]',
            ]);


            Artisan::call('make:observer '.$name.'Observer --model='.$name);

            $observerImport = 'use App\Observers\\' . $name . 'Observer;';

            $modelTemplate = <<<EOT
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashableTrait;
{$observerImport}

class {$name} extends Model
{
    use SoftDeletes, HashableTrait;

    protected \$fillable = [
        // Specify your fillable fields here...
    ];

    protected \$appends = [
        'hash_id'
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
        ->addColumn('action', function (\$item) {
            return view('{$blade_path}.components.{$lowerName}.dataTableActions', compact('item'))->render();
        })
        ->addIndexColumn()
        ->rawColumns(['action'])->toJson();

    }

    public function find(\$hashId)
    {
        return \$this->{$lowerName}->findOrFailByHash(\$hashId);
    }

    public function store(array \$attributes)
    {
        {$name}::create(\$attributes);
    }

    public function update(array \$attributes, \$hashId)
    {
        \$item = \$this->find(\$hashId);
        \$item->update(\$attributes);
    }

    function delete(\$hashId)
    {
        \${$lowerName} = \$this->find(\$hashId);

        return \${$lowerName}->delete();

    }
    function changeStatus(\$hashId)
    {
        \${$lowerName} = \$this->find(\$hashId);
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
            $controller_namespace = rtrim(str_replace("/", "\\", env($this->argument('module').'_CONTROLLER_PATH')), "\\");
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
                'permission' => '{$module}.{$lowerName}.index',
                'parameters' => [],
            ],
            'dataTable' => [
                'permission' => '{$module}.{$lowerName}.index',
                'parameters' => ['request'],
            ],
            'create' => [
                'permission' => '{$module}.{$lowerName}.create',
                'parameters' => [],
            ],
            'edit' => [
                'permission' => '{$module}.{$lowerName}.edit',
                'parameters' => ['hashId'],
            ],
            'show' => [
                'permission' => '{$module}.{$lowerName}.show',
                'parameters' => ['hashId'],
            ],
        ],
        'POST' => [
            'store' => [
                'permission' => '{$module}.{$lowerName}.create',
                'parameters' => ['{$name}Request'],
            ],
            'update' => [
                'permission' => '{$module}.{$lowerName}.edit',
                'parameters' => ['{$name}Request','hashId'],
            ],
            'destroy' => [
                'permission' => '{$module}.{$lowerName}.delete',
                'parameters' => ['hashId'],
            ],
            'changeStatus' => [
                'permission' => '{$module}.{$lowerName}.changeStatus',
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
            'button_title' => getLabel('general.save'),
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
            return \$this->generalResponse(true, 200, getLabel('general.success_m'), []);

        } catch (\Exception \$e) {
            MainHelper::make_error_report([
                'error'=>\$e->getMessage(),
                'error_code'=>500,
                'details'=>"Error : ".\$e->getFile()." Line : ". \$e->getLine() . json_encode(request()->instance())
            ]);
            return \$this->generalResponse(false, 422, getLabel('general.fail_m'), []);
        }

    }

    public function show(\$hashId)
    {
        \$data = \$this->{$lowerName}Repository->find(\$hashId);
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
            'button_title' => getLabel('general.save'),
            'item' => \$item,
            'validation' => \$this->getValidation(new {$name}Request())

        ];

        \$view =  view()->make('{$blade_path}.{$lowerName}.modal', \$data)->render();

        return \$this->generalResponse('TRUE','200','SUCCESS', 'HTML',\$view);
    }

    public function update({$name}Request \$request, \$hashId)
    {
        try {
            DB::transaction(function () use (\$hashId, \$request) {
            \$this->{$lowerName}Repository->update(\$request->validated(), \$hashId);
        });

        return \$this->generalResponse(true, 200, getLabel('general.success_m'), []);
        } catch (\Exception \$e) {
            MainHelper::make_error_report([
                'error' => \$e->getMessage(),
                'error_code' => 500,
                'details' => "Error : ".\$e->getFile()." Line : ". \$e->getLine() . json_encode(request()->instance())
            ]);

            return \$this->generalResponse(false, 500, getLabel('general.fail_m'), []);
        }

    }

    public function destroy(\$hashId)
    {
        \${$lowerName}Destroy = \$this->{$lowerName}Repository->delete(\$hashId);

        if (\${$lowerName}Destroy)
            return \$this->generalResponse(true, 200, getLabel('general.success_m'), []);
        return \$this->generalResponse(false, 422, getLabel('general.fail_m'), []);
    }

    public function changeStatus(\$hashId)
    {
        return \$this->{$lowerName}Repository->changeStatus(\$hashId);
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

            // Create the views
            $viewsDir = resource_path("views/" . env($this->argument('module').'_BLADE_PATH') . "{$lowerName}");
            $viewsComponentsDir = resource_path("views/" . env($this->argument('module').'_BLADE_PATH') . "components/{$lowerName}");
            if (!File::exists($viewsComponentsDir)) {
                File::makeDirectory($viewsComponentsDir, 0777, true);
            }
            if (!File::exists($viewsDir)) {
                File::makeDirectory($viewsDir, 0777, true);
            }


            $bladeTemplate = <<<EOT
@extends('{$main_layout}')

@section('content')
<!-- Your HTML content goes here -->

@endsection
@section('scripts')

    <script src="{{ asset('{$js_path}{$lowerName}.js') }}"></script>

@endsection
EOT;

            $indexBladeTemplate = <<<EOT
@extends('{$main_layout}')

@section('content')
<div class="px-10">
        <!--  breadcrumb -->
        <div class="breadcrumb-area py-0 mb-10">
            <h3 class="md:text-2xl text-lg font-semibold mb-2"> نص تجريبي </h3>
            <div class="breadcrumb">
                <ul class="m-0">
                    <li>
                        <a href=""> <i class="icon-feather-home"></i> </a>
                    </li>
                    <li class="active">
                        <a href="{{ route('{$module}.{$lowerName}') }}">نص تجريبي</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white shadow rounded-md overflow-auto">

            <div class="justify-between p-5 sm:flex">
                <h3 class="md:-mb-2 mb-2 capitalize font-semibold text-xl">نص تجريبي </h3>
                <div class="flex items-center space-x-3">
                    @if(userHasPermissions('{$module}.{$lowerName}.create'))
                        <a href="javascript:;" class="flex items-center justify-center h-9 px-6 rounded-md hover:bg-blue-700 text-white bg-blue-600"
                            data-event_on="click"
                            data-action_name="CREATE"
                            data-controller_function="create"
                            data-request_method="GET"
                            data-target_modal="#create-{$lowerName}-mdl"
                            data-spinner_on="this"
                        >
                            <ion-icon name="add-outline" class="ml-2"></ion-icon>
                            <span>{{ getLabel('general.add') }}</span>
                        </a>
                    @endif
                </div>
            </div>
            <div>


                <table class="w-full border-b datatable-table width-100" id="{$lowerName}_tbl">
                    <thead>
                        <tr class="bg-gray-50 sm:text-base text-sm text-black border-b">
                            <th class="p-2 font-medium w-10 text-center">#</th>

                            <th class="p-2 font-medium text-center w-12">{{ getLabel('general.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>


    </div>

@endsection
@section('scripts')

    <script>
        window.app = new Application({
            page_url: "{{ route('{$module}.{$lowerName}') }}",
        });
    </script>
    <script src="{{ asset('assets/global/js/datatable.js') }}"></script>
    <script src="{{ asset('assets/global/js/libraries/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/global/js/libraries/dataTables.uikit.js') }}"></script>
    <script src="{{ asset('assets/global/js/libraries/jquery.validate.js') }}"></script>

    <script src="{{ asset('{$js_path}{$lowerName}.js') }}"></script>


@endsection
EOT;
if($hasSimpleModal == 1){

    $modalBladeTemplate = <<<EOT
    <div id="{{ \$modal_id }}" class="modal-width-medium" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
        <div class="text-right py-3 border-b">
            <h3 class="text-lg font-semibold mr-4" id="modal_title">{{ \$modal_title }}</h3>
            <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 left-2" type="button" uk-close
                uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
        </div>    
        <form method="post" id="{{ \$form_id }}" >
            @csrf
    
            <div class="p-8">
                <div class="grid sm:grid-cols-3 align-items-baseline sm:gap-6 gap-2 md:mt-4">
                    1
                </div>
            </div>

            <div class="flex items-center w-full justify-end border-t py-3 mt-2">
                    <div class="flex space-x-2 px-3">
                        <button 
                        data-event_on="click"
                        data-form="#{{ \$form_id }}"
                        data-spinner_on="this"
                        @isset(\$item)
                            data-action_name="UPDATE" data-controller_function="update" data-hash_id="{{\$item->hash_id}}"
                        @else
                            data-action_name="STORE" data-controller_function="store"
                        @endisset
                        class="bg-blue-600 flex h-9 items-center text-white hover:text-white hover:bg-blue-700 justify-center rounded-md text-white px-5 font-medium" data-type="submit">
                            <ion-icon name="checkmark-outline" class="ml-2 check-icon"></ion-icon>
                            <span class="submit-text">{{ \$button_title }}</span>
                        </button>
        
                    </div>
        
                </div>
    
    
            
            </form>
            
    
    
        </div>
    </div>
    <script src="{{ asset('assets/global/js/libraries/jquery.validate.js') }}"></script>
    
    <script type="text/javascript">
    
        window.app.setUpValidation("#{{ \$form_id }}", @json(\$validation));
    
    
    </script>
    
    
    EOT;

}else{


            $modalBladeTemplate = <<<EOT
<div id="{{ \$modal_id }}" class="custom-offcanvas-width" uk-offcanvas="overlay: true ; flip: true">
    <div class="uk-offcanvas-bar bg-white p-7 shadow-2xl">
        <button class="uk-offcanvas-close m-2" type="button" uk-close></button>

        <h3 class="font-medium mb-3 text-2xl pr-8 modelTitle">{{ \$modal_title }}</h3>

        <form method="post" id="{{ \$form_id }}" >
        @csrf

        <nav class="msf-header cd-secondary-nav extanded px-6 border-b">
            <ul class="space-x-3">
                <li class="msf-step"><a href="javascript:;" onClick="Active{$name}Step(0)">
                        <ion-icon name="document-text-outline" class="pr-2 text-2xl lg:block hidden"></ion-icon>&nbsp;
                        نافدة 1 </a></li>
                <li class="msf-step"><a href="javascript:;" onClick="Active{$name}Step(1)">
                        <ion-icon name="person-circle" class="pr-2 text-2xl lg:block hidden"></ion-icon>
                        &nbsp;نافدة 2</a></li>

                        <li class="msf-step"><a href="javascript:;" onClick="Active{$name}Step(2)">
                            <ion-icon name="person-circle" class="pr-2 text-2xl lg:block hidden"></ion-icon>
                            &nbsp;نافدة 3</a></li>

            </ul>
        </nav>

        <div class="msf-content">
            <div class="msf-view p-8">

                1

            </div>

            <div class="msf-view p-8">

                2

            </div>

            <div class="msf-view p-8">

                3

            </div>

        </div>


         <div class="msf-navigation px-8">
            <div class="d-flex gap-4 justify-end">

                <button type="button" data-type="back"
                        class="bg-gray-100 rounded-md py-3 px-5 text-gray-600 hover:text-gray-600 hover:bg-gray-200 flex items-center">
                    <ion-icon name="arrow-back-outline" class="ml-2"></ion-icon>
                    <span>{{ getLabel('general.previous') }}</span>
                </button>

                <button type="button" data-type="next"
                        class="bg-blue-500 rounded-md py-3 px-5 text-white hover:text-white hover:bg-blue-600 flex items-center">
                    <span>{{ getLabel('general.next') }}</span>
                    <ion-icon name="arrow-forward-outline" class="mr-2"></ion-icon>
                </button>

                <button
                    data-type="submit"
                    data-event_on="click"
                    data-form="#{{ \$form_id }}"
                    data-spinner_on="this"
                    @isset(\$item)
                        data-action_name="UPDATE" data-controller_function="update" data-hash_id="{{\$item->hash_id}}"
                    @else
                        data-action_name="STORE" data-controller_function="store"
                    @endisset

                    class="bg-blue-500 rounded-md py-3 px-5 text-white hover:text-white hover:bg-blue-600 flex items-center">
                    
                    <ion-icon name="checkmark-outline" class="ml-2 check-icon"></ion-icon>
                    <span class="submit-text">{{ \$button_title }}</span>
                </button>

                </div>
            </div>
        </form>
        <div class="congratulation-box" style="display: none;"
            uk-scrollspy="cls: uk-animation-slide-bottom; target: .congrats; repeat: true">


            <div class="flex flex-col items-center justify-center congrats mt-28">
                <img src="{{ asset('front-assets/portal-assets/images/congrats.jpeg') }}" class="w-1/2"
                    alt="">
                <h6 class="font-semibold text-2xl"> {{ getLabel('general.thanks') }}</h6>
                <h1 class="font-medium mb-5 text-gray-500 text-center mt-5"> {{ \$success_message }}</h1>

            </div>
        </div>


    </div>
</div>
<script src="{{ asset('assets/global/js/libraries/jquery.validate.js') }}"></script>

<script src="{{ asset('assets/global/js/libraries/multi-step-form.js') }}"></script>
<script type="text/javascript">
    var {$lowerName}_msf = null;

    {$lowerName}_msf =  $("#{{ \$form_id }}").multiStepForm({
        activeIndex: 0,
        allowClickNavigation: true,
        allowUnvalidatedStep: false,
        hideBackButton: false,

    });

    function Active{$name}Step(activeIndex) {
        if (isDefined($("#{{ \$form_id }}").valid)) {
            if (!$("#{{ \$form_id }}").valid()) {
                return;
            }
        }
      {$lowerName}_msf.setActiveView(activeIndex);
    }

    window.app.setUpValidation("#{{ \$form_id }}", @json(\$validation));


</script>


EOT;
}


$dataTableActionsTemplate = <<<EOT

<a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full" aria-expanded="false">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
    </svg>
</a>
<div class="bg-white w-44 shadow-lg border border-gray-100 p-2 mt-12 rounded-md text-gray-500 hidden text-right font-medium"
            uk-drop="pos: bottom-right; mode: click">
    <ul class="space-y-1">
        @if(userHasPermissions('{$module}.{$lowerName}.edit'))
            <li>
                <a href="javascript:;" data-hash_id="{{ \$item->hash_id }}" data-event_on="click" data-action_name="EDIT" data-controller_function="edit" data-spinner_on="this" data-request_method="GET" data-target_modal="#edit-{$lowerName}-mdl" class="px-3 py-2 rounded-md block hover:bg-gray-100 text-right flex items-center" >
                    <ion-icon name="create-outline" class="ml-1 text-lg md hydrated" role="img" aria-label="create outline"></ion-icon>
                    <span>{{ getLabel('general.edit') }}</span>
                </a>
            </li>
        @endif

        @if(userHasPermissions('{$module}.{$lowerName}.delete'))

            <li>
                <a href="javascript:;" data-hash_id="{{ \$item->hash_id }}" data-event_on="click" data-action_name="DELETE" data-controller_function="destroy" data-spinner_on="body" class="px-3 py-2 rounded-md block text-red-500 hover:bg-red-100 hover:text-red-500 text-right flex items-center">
                    <ion-icon name="trash-outline" class="ml-1 text-lg md hydrated" role="img" aria-label="create outline"></ion-icon>

                    <span>{{ getLabel('general.delete') }}</span>
                </a>
            </li>
        @endif

    </ul>
</div>



EOT;

            File::put("{$viewsDir}/index.blade.php", $indexBladeTemplate);
            File::put("{$viewsDir}/show.blade.php", $bladeTemplate);

            File::put("{$viewsDir}/modal.blade.php", $modalBladeTemplate);
            File::put("{$viewsComponentsDir}/dataTableActions.blade.php", $dataTableActionsTemplate);

            $this->info("Views for {$name} created successfully.");

            // Create the JS file
            $jsDir = public_path(env($this->argument('module').'_JS_PATH') . "");

            if (!File::exists($jsDir)) {
                File::makeDirectory($jsDir, 0777, true);
            }

            $jsTemplate = <<<EOT
var {$lowerName}_tbl = $("#{$lowerName}_tbl");
var {$lowerName}_msf = null;


window.app.defineEvents();


/* {$name} DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#{$lowerName}_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function(filter) {
                
            }
        }
    }
});






EOT;

            File::put("{$jsDir}/{$lowerName}.js", $jsTemplate);
            $this->info("JS file for {$name} created successfully.");

            $routesDir = base_path("routes");
            $controller_path_name = str_replace("/", "\\", env($this->argument('module').'_CONTROLLER_PATH')) . $name . "Controller";

            $routesTemplate = <<<EOT

Route::match(['post', 'get'],'{$lowerName}/{controllerFunction?}/{hashId?}',App\\{$controller_path_name}::class)->name('{$lowerName}');

EOT;
$modelNameLower = strtolower($this->argument('module')) != 'main' ? strtolower($this->argument('module')) : 'web';
            File::append("{$routesDir}/{$modelNameLower}.php", $routesTemplate);
            $this->info("Routes for {$name} added successfully.");
        }


        

}
