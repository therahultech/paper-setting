<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaperAllocationController;
use App\Http\Controllers\PaperUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PhpMailController;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/mail', [MailController::class, 'index'])->name('mail.index');


Route::get('send-php-mail',[PhpMailController::class, 'index'])->name('send.php.mailer');
Route::post('send-php-mailer-submit',[PhpMailController::class, 'store'])->name('send.php.mailer.submit');


Route::group(['middleware' => 'auth'], function() {
    Route::get('paper_Upload/create/{paper_allocation_id}',[PaperUploadController::class, 'create']);
    Route::get('paper_Upload/viewBill/{paper_upload_id}',[PaperUploadController::class, 'viewBill']);
    Route::post('paper_Upload/billSubmitToSecy',[PaperUploadController::class, 'billSubmitToSecy']);
    Route::get('paper/viewAllBill', [PaperController::class, 'viewAllBill']);
    Route::get('paper/viewBill/{id}',[PaperController::class, 'viewBill']);
    Route::post('paper/billUpdateOtherDeduct',[PaperController::class, 'billUpdateOtherDeduct']);
    Route::post('paper/billSubmitToAcc',[PaperController::class, 'billSubmitToAcc']);

    Route::resource('course',CourseController::class);
    Route::resource('department',DepartmentController::class);
    Route::resource('subject',SubjectController::class);
    Route::resource('paper',PaperController::class);
    Route::resource('teacher',TeacherController::class);
    Route::resource('session',SessionController::class);
    Route::resource('event',EventController::class);
    Route::resource('paper_Allocation',PaperAllocationController::class);
    Route::resource('paper_Upload',PaperUploadController::class)->except(['create']);
    // Route::post('paper_Upload/create',[PaperUploadController::class, 'create']);
    
  });




  Route::get('/password', [PasswordController::class, 'index'])->name('password.index');
  Route::post('/password/generate', [PasswordController::class, 'generate'])->name('password.generate');

  Route::get('/getEventsBySessionId/{session_id}', [EventController::class, 'getEventsBySessionId']);
  

// Route::resource('course',CourseController::class);
// Route::resource('department',DepartmentController::class);

Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
});

Route::get('/debug', function () {
    return [
        'Laravel Timezone' => config('app.timezone'),
        'PHP Timezone' => date_default_timezone_get(),
        'Current Time' => now()->toDateTimeString(),
    ];
});



require __DIR__.'/auth.php';
