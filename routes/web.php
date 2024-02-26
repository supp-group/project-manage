<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// index
Route::get('/index', [AdminController::class, 'index']);



// Route::get('/getCount', [MemberController::class, 'GetCityWithMemberCount'])->name('getCount');
// Route::get('/cityMember', [MemberController::class, 'GetCityWithMember'])->name('cityMember');



// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])-> prefix('admin')->group(function () {

    //index
    // Route::get('', [AdminController::class, 'index']);

    Route::get('show-members', [MemberController::class, 'index']);

    // Route::get('/getCount', [MemberController::class, 'GetCityWithMemberCount'])->name('getCount');


    //Excel
    Route::post('/import', [MemberController::class, 'import'])->name('import');
    Route::get('/export', [MemberController::class, 'exportDataToCSV'])->name('export');
    // Route::get('/export', [MemberController::class, 'export'])->name('export');



    //   /member
    Route:: prefix('member')->group(function () {

        Route::get('show', [MemberController::class, 'index']);
        Route::get('add', [MemberController::class, 'create']);
        Route::post('save', [MemberController::class, 'store'])->name('member.save');
    
        Route::get('edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
        Route::post('update/{id}', [MemberController::class, 'update'])->name('member.update');

        Route::delete('delete/{id}', [MemberController::class, 'destroy'])->name('member.delete');

        Route::get('/get-specializations/{qualificationId}',[MemberController::class, 'getSpecializations']);

        // search
        Route::post('team', [MemberController::class, 'searchByIDTeam'])->name('search-team');
        Route::post('name', [MemberController::class, 'searchByName'])->name('search-name');
        Route::post('city', [MemberController::class, 'searchByCity'])->name('search-city');

        Route::post('qualification', [MemberController::class, 'searchByQualification'])->name('search-qualification');
        Route::post('specialization', [MemberController::class, 'searchBySpecialization'])->name('search-specialization');
        Route::post('occupation', [MemberController::class, 'searchByOccupation'])->name('search-occupation');


        //order
        Route::get('last', [MemberController::class, 'orderBy_Last'])->name('order-last');
        Route::get('name', [MemberController::class, 'orderBy_Name'])->name('order-name');
        Route::get('team', [MemberController::class, 'orderBy_IDTeam'])->name('order-team');
        Route::get('join', [MemberController::class, 'orderBy_DateOfJoin'])->name('order-join');

    });

    //   /user  ===>  manager
   Route:: prefix('user')->group(function () {

    Route::get('show', [UserController::class, 'index']);
    Route::get('add', [UserController::class, 'create']);
    Route::post('save', [UserController::class, 'store'])->name('user.save');

    Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('user.update');

    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });

   //   /city
   Route:: prefix('city')->group(function () {

    Route::get('show', [CityController::class, 'index']);
    Route::get('add', [CityController::class, 'create']);
    Route::post('save', [CityController::class, 'store'])->name('city.save');

    Route::get('edit/{id}', [CityController::class, 'edit'])->name('city.edit');
    Route::post('update/{id}', [CityController::class, 'update'])->name('city.update');

    Route::delete('delete/{id}', [CityController::class, 'destroy'])->name('city.delete');
    });

  //   /occupation
  Route:: prefix('occupation')->group(function () {

    Route::get('show', [OccupationController::class, 'index']);
    Route::get('add', [OccupationController::class, 'create']);
    Route::post('save', [OccupationController::class, 'store'])->name('occupation.save');

    Route::get('edit/{id}', [OccupationController::class, 'edit'])->name('occupation.edit');
    Route::post('update/{id}', [OccupationController::class, 'update'])->name('occupation.update');

    Route::delete('delete/{id}', [OccupationController::class, 'destroy'])->name('occupation.delete');
    });

  //   /qualification
  Route:: prefix('qualification')->group(function () {

    Route::get('show', [QualificationController::class, 'indexQualification']);
    Route::get('add', [QualificationController::class, 'createQualification']);
    Route::post('save', [QualificationController::class, 'storeQualification'])->name('qualification.save');

    Route::get('edit/{id}', [QualificationController::class, 'editQualification'])->name('qualification.edit');
    Route::post('update/{id}', [QualificationController::class, 'updateQualification'])->name('qualification.update');

    Route::delete('delete/{id}', [QualificationController::class, 'destroyQualification'])->name('qualification.delete');
    });

    //   /specialization
    Route:: prefix('specialization')->group(function () {

        Route::get('show', [QualificationController::class, 'indexSpecialization']);
        Route::get('add', [QualificationController::class, 'createSpecialization']);
        Route::post('save', [QualificationController::class, 'storeSpecialization'])->name('specialization.save');

        Route::get('edit/{id}', [QualificationController::class, 'editSpecialization'])->name('specialization.edit');
        Route::post('update/{id}', [QualificationController::class, 'updateSpecialization'])->name('specialization.update');

        Route::delete('delete/{id}', [QualificationController::class, 'destroySpecialization'])->name('specialization.delete');
    });

});



// Manager Routes
Route::middleware(['auth', 'verified', 'manager'])-> prefix('manager')->group(function () {

    //index
    // Route::get('', [AdminController::class, 'index']);


    //Excel
    Route::get('/export', [MemberController::class, 'exportDataToCSV'])->name('exportm');


    //   /memberm
    Route:: prefix('memberm')->group(function () {

        Route::get('show', [MemberController::class, 'index']);
        Route::get('add', [MemberController::class, 'create']);
        Route::post('save', [MemberController::class, 'store'])->name('memberm.save');
    
        Route::get('edit/{id}', [MemberController::class, 'edit'])->name('memberm.edit');
        Route::post('update/{id}', [MemberController::class, 'update'])->name('memberm.update');

        Route::delete('delete/{id}', [MemberController::class, 'destroy'])->name('memberm.delete');

        Route::get('/get-specializations/{qualificationId}',[MemberController::class, 'getSpecializations']);

        // search
        Route::post('team', [MemberController::class, 'searchByIDTeam'])->name('search-m-team');
        Route::post('name', [MemberController::class, 'searchByName'])->name('search-m-name');

        Route::post('qualification', [MemberController::class, 'searchByQualification'])->name('search-m-qualification');
        Route::post('specialization', [MemberController::class, 'searchBySpecialization'])->name('search-m-specialization');
        Route::post('occupation', [MemberController::class, 'searchByOccupation'])->name('search-m-occupation');


        //order
        Route::get('last', [MemberController::class, 'orderBy_Last'])->name('order-m-last');
        Route::get('name', [MemberController::class, 'orderBy_Name'])->name('order-m-name');
        Route::get('team', [MemberController::class, 'orderBy_IDTeam'])->name('order-m-team');
        Route::get('join', [MemberController::class, 'orderBy_DateOfJoin'])->name('order-m-join');

    });

});



require __DIR__.'/auth.php';

