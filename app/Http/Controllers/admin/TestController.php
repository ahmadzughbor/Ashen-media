<?php

namespace App\_CONTROLLER_PATH;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;
use App\Repositories\Interfaces\TestRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Helpers\MainHelper;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    use ResponseTrait;

    protected $testRepository;


    /**
     * array `functions` to classification of functions
     *
     * @var array
     */
    protected $functions = [
        'GET' => [
            'index' => [
                'permission' => 'test.index',
                'parameters' => [],
            ],
            'dataTable' => [
                'permission' => 'test.index',
                'parameters' => ['request'],
            ],
            'create' => [
                'permission' => 'test.create',
                'parameters' => [],
            ],
            'edit' => [
                'permission' => 'test.edit',
                'parameters' => ['hashId'],
            ],
            'show' => [
                'permission' => 'test.show',
                'parameters' => ['hashId'],
            ],
        ],
        'POST' => [
            'store' => [
                'permission' => 'test.create',
                'parameters' => ['TestRequest'],
            ],
            'update' => [
                'permission' => 'test.edit',
                'parameters' => ['TestRequest','hashId'],
            ],
            'destroy' => [
                'permission' => 'test.delete',
                'parameters' => ['hashId'],
            ],
            'changeStatus' => [
                'permission' => 'test.changeStatus',
                'parameters' => ['hashId'],
            ],
        ],
    ];

    public function __invoke(Request $request, $controllerFunction = "index",$hashId = null)
    {
        $method = $request->method();

        if (isset($this->functions[$method][$controllerFunction])) {
            $permission = $this->functions[$method][$controllerFunction]['permission'];
            if($permission){
                if (auth()->check() && !userHasPermissions($permission)) {
                    return response()->json(['error' => 'Function is not found or unauthorized'], 404);
              }
            }

            $parameters = $this->functions[$method][$controllerFunction]['parameters'];

            if (!empty($parameters)) {
                $params = [];
                foreach ($parameters as $param) {
                    if ($param === 'TestRequest') {
                        $params[] = app()->make(TestRequest::class);
                    }
                    elseif ($param === 'request') {
                        $params[] = $request;
                    } elseif ($param === 'hashId') {
                        $params[] = $hashId;
                    } else {
                        $params[] = $request->input($param);
                    }
                }
                return $this->$controllerFunction(...$params);
            }

            return $this->$controllerFunction();

        }

        return response()->json(['error' => 'Function is not found or unauthorized'], 404);
    }


    public function __construct(TestRepositoryInterface $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    public function index()
    {
        return view('.test.index');
    }

    public function dataTable(Request $request)
    {
        return $this->testRepository->dataTable($request->all());
    }

    public function create()
    {
        $data =  [
            'form_id' => 'test-createForm',
            'button_class' => 'submitTest-btn',
            'modal_id' => 'create-test-mdl',
            'modal_title' => 'عنون المودل',
            'success_message' => 'رسالة نجاح العملية',
            'button_title' => "save",
            'validation' => $this->getValidation(new TestRequest())

        ];
        $view =  view()->make('.test.modal', $data)->render();

        return $this->generalResponse('TRUE','200','SUCCESS', 'HTML',$view);

    }

    public function store(TestRequest $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $this->testRepository->store($request->validated());
            });
            return $this->generalResponse(true, 200, "SUCCESS", []);

        } catch (\Exception $e) {
            return $e;

            return $this->generalResponse(false, 422, "fail_m", []);
        }

    }

    public function show($Id)
    {
        $data = $this->testRepository->find($Id);
        return view('.test.show', compact('data'));
    }

    public function edit($hashId)
    {
    $item = $this->testRepository->find($hashId);

        $data = [
            'form_id' => 'test-editForm',
            'button_class' => 'updateTest-btn',
            'modal_id' => 'edit-test-mdl',
            'modal_title' => ' ',
            'success_message' => ' ',
            'button_title' => "save",
            'item' => $item,
            'validation' => $this->getValidation(new TestRequest())

        ];

        $view =  view()->make('.test.modal', $data)->render();

        return $this->generalResponse('TRUE','200','SUCCESS', 'HTML',$view);
    }

    public function update(TestRequest $request, $Id)
    {
        try {
            DB::transaction(function () use ($Id, $request) {
            $this->testRepository->update($request->validated(), $Id);
        });

        return $this->generalResponse(true, 200, "SUCCESS", []);
        } catch (\Exception $e) {
             
            return $e;

            return $this->generalResponse(false, 500, "failed", []);
        }

    }

    public function destroy($Id)
    {
        $testDestroy = $this->testRepository->delete($Id);

        if ($testDestroy)
            return $this->generalResponse(true, 200, "SUCCESS" , []);
        return $this->generalResponse(false, 422,"fail_m"  , []);
    }

    public function changeStatus($Id)
    {
        return $this->testRepository->changeStatus($Id);
    }
}