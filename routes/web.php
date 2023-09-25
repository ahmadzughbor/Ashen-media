<?php

use App\Http\Controllers\aboutController;
use App\Http\Controllers\fronController;
use App\Http\Controllers\packagesController;
use App\Http\Controllers\partnersController;
use App\Http\Controllers\peopleMessageController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\saysController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\statisticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('layouts.admin.index');
});


Route::get('/frontend/{locale?}', [fronController::class, 'index'])->name('frontend.index');

Route::middleware(['auth'])->prefix('admin')->group(function () {



    Route::get('/slider', [SlidersController::class, 'index'])->name("slider.index");
    Route::get('/slider/create', [SlidersController::class, 'create'])->name('slider.create');
    Route::get('/slider/data', [SlidersController::class, 'data'])->name('slider.data');
    Route::get('/slider/edit/{id?}', [SlidersController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/update/{id?}', [SlidersController::class, 'update'])->name('slider.update');
    Route::delete('/slider/delete/{id?}', [SlidersController::class, 'destroy'])->name('slider.delete');
    Route::post('/slider/store', [SlidersController::class, 'store'])->name('slider.store');


    //////////////about section 


    Route::get('/aboutus', [aboutController::class, 'index'])->name("aboutus.index");
    Route::get('/indexVision', [aboutController::class, 'indexVision'])->name("aboutus.indexVision");
    Route::get('/indexmission', [aboutController::class, 'indexmission'])->name("aboutus.indexmission");
    Route::get('/indexgoals', [aboutController::class, 'indexgoals'])->name("aboutus.indexgoals");
    Route::post('/aboutus/store', [aboutController::class, 'store'])->name("aboutus.store");
    Route::post('/aboutus/storeVision', [aboutController::class, 'storeVision'])->name("aboutus.storeVision");
    Route::post('/aboutus/storemission', [aboutController::class, 'storemission'])->name("aboutus.storemission");
    Route::post('/aboutus/storegoals', [aboutController::class, 'storegoals'])->name("aboutus.storegoals");


    //////////////// servises


    Route::get('/service', [serviceController::class, 'index'])->name("service.index");
    Route::get('/service/create', [serviceController::class, 'create'])->name('service.create');
    Route::get('/service/data', [serviceController::class, 'data'])->name('service.data');
    Route::get('/service/edit/{id?}', [serviceController::class, 'edit'])->name('service.edit');
    Route::post('/service/update/{id?}', [serviceController::class, 'update'])->name('service.update');
    Route::delete('/service/delete/{id?}', [serviceController::class, 'destroy'])->name('service.delete');
    Route::post('/service/store', [serviceController::class, 'store'])->name('service.store');



    /////////////// projects



    Route::get('/project', [projectController::class, 'index'])->name("project.index");
    Route::get('/project/create', [projectController::class, 'create'])->name('project.create');
    Route::get('/project/data', [projectController::class, 'data'])->name('project.data');
    Route::get('/project/edit/{id?}', [projectController::class, 'edit'])->name('project.edit');
    Route::post('/project/update/{id?}', [projectController::class, 'update'])->name('project.update');
    Route::delete('/project/delete/{id?}', [projectController::class, 'destroy'])->name('project.delete');
    Route::post('/project/store', [projectController::class, 'store'])->name('project.store');

    //////////////// Statistic



    Route::get('/Statistic', [statisticsController::class, 'index'])->name("Statistic.index");
    Route::post('/Statistic/store', [statisticsController::class, 'store'])->name("Statistic.store");

    ///////////////// packages



    Route::get('/packages', [packagesController::class, 'index'])->name("packages.index");
    Route::get('/packages/create', [packagesController::class, 'create'])->name('packages.create');
    Route::get('/packages/data', [packagesController::class, 'data'])->name('packages.data');
    Route::get('/packages/edit/{id?}', [packagesController::class, 'edit'])->name('packages.edit');
    Route::post('/packages/update/{id?}', [packagesController::class, 'update'])->name('packages.update');
    Route::delete('/packages/delete/{id?}', [packagesController::class, 'destroy'])->name('packages.delete');
    Route::post('/packages/store', [packagesController::class, 'store'])->name('packages.store');

    //////////////////// says 



    Route::get('/say', [saysController::class, 'index'])->name("say.index");
    Route::get('/say/create', [saysController::class, 'create'])->name('say.create');
    Route::get('/say/data', [saysController::class, 'data'])->name('say.data');
    Route::get('/say/edit/{id?}', [saysController::class, 'edit'])->name('say.edit');
    Route::post('/say/update/{id?}', [saysController::class, 'update'])->name('say.update');
    Route::delete('/say/delete/{id?}', [saysController::class, 'destroy'])->name('say.delete');
    Route::post('/say/store', [saysController::class, 'store'])->name('say.store');


    ////////////////// partners


    Route::get('/partners', [partnersController::class, 'index'])->name("partner.index");
    Route::get('/partners/create', [partnersController::class, 'create'])->name('partner.create');
    Route::get('/partners/data', [partnersController::class, 'data'])->name('partner.data');
    Route::get('/partners/edit/{id?}', [partnersController::class, 'edit'])->name('partner.edit');
    Route::post('/partners/update/{id?}', [partnersController::class, 'update'])->name('partner.update');
    Route::delete('/partners/delete/{id?}', [partnersController::class, 'destroy'])->name('partner.delete');
    Route::post('/partners/store', [partnersController::class, 'store'])->name('partner.store');



    /////////////// Contact Us

    Route::get('/ContactUs', [peopleMessageController::class, 'index'])->name("ContactUs.index");
    Route::post('/ContactUs/store', [peopleMessageController::class, 'store'])->name('ContactUs.store');
    Route::get('/ContactUs/data', [peopleMessageController::class, 'data'])->name('ContactUs.data');


    //////////////////////  settings

    Route::get('/settings', [settingsController::class, 'index'])->name("settings.index");
    Route::post('/settings/store', [settingsController::class, 'store'])->name("settings.store");
});


include 'auth.php';

