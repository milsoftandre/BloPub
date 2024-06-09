<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\HandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MessagesController;
use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\AgentController;

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

Route::get('/lang/{locale}', function ($locale,Request $request) {
    if (! in_array($locale, ['en', 'ru', 'fr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect(route('dashboard'));
    return view('welcome', compact('request'));
})->name('lang');

Route::get('/', function (Request $request) {
   // dd(Auth::user());
   // return redirect(route('tasks.index'));
    return view('welcome', compact('request'));
})->middleware('auth')->name('dashboard');

Route::get('/apid', function (Request $request) {
    // dd(Auth::user());
    // return redirect(route('tasks.index'));
    $settings = \App\Models\Employee::settings(1,0);
    return view('api', compact('request', 'settings'));
})->name('apid');

Route::get('profile', [EmployeeController::class,'profile'])->middleware('auth')->name('profile');


Route::resource('settings', SettingsController::class)->middleware('auth');

Route::resource('employee', EmployeeController::class)->middleware('auth');
Route::resource('hand', HandController::class)->middleware('auth');
Route::resource('client', ClientController::class)->middleware('auth');
Route::resource('agent', AgentController::class)->middleware('auth');

Route::get('/withdrawal/ch', [WithdrawalController::class, 'ch'])->middleware('auth')->name('wch');

Route::resource('withdrawal', WithdrawalController::class)->middleware('auth');
Route::resource('finance', FinanceController::class)->middleware('auth');
Route::resource('cat', CatController::class)->middleware('auth');
Route::resource('templates', TemplatesController::class)->middleware('auth');

Route::resource('group', GroupController::class)->middleware('auth');
Route::resource('services', ServicesController::class)->middleware('auth');
Route::resource('docs', DocsController::class)->middleware('auth');
Route::get('/ndocs', [DocsController::class, 'show'])->name('ndocs');

Route::get('/tasks/ch', [TasksController::class, 'ch'])->middleware('auth')->name('ch');




Route::get('/tasks/delfiles', [TasksController::class, 'delfiles'])->middleware('auth')->name('delfiles');
Route::get('/tasks/updatech', [TasksController::class, 'updatech'])->middleware('auth')->name('updatech');

Route::get('tasks-copy', [TasksController::class, 'copy'])->name('tasks.copy');

Route::resource('tasks', TasksController::class)->middleware('auth');




Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('custom-login', [LoginController::class, 'customLogin'])->name('login.custom');

Route::get('reset', [LoginController::class, 'resetindex'])->name('reset');
Route::post('reset-login', [LoginController::class, 'reset'])->name('login.reset');

Route::get('getcode', [LoginController::class, 'getcode'])->name('getcode');
Route::get('isgetcode', [LoginController::class, 'isgetcode'])->name('isgetcode');

Route::get('/logout', [LoginController::class, 'perform'])->name('logout');


Route::get('/register/{id}/{h}', function ($id,$h) {
    // dd(Auth::user());
    return view('auth.register', compact('id'));
})->name('register');
Route::post('custom-register', [HandController::class, 'store'])->name('registerstore');


Route::get('/chat', [MessagesController::class, 'index'])->middleware('auth')->name('chat');
Route::get('/chatsend', [MessagesController::class, 'create'])->middleware('auth')->name('chatsend');
Route::get('/chatmes', [MessagesController::class, 'show'])->middleware('auth')->name('chatmes');


Route::get('/commentsend', [CommentController::class, 'create'])->middleware('auth')->name('commentsend');
Route::get('/commentmes', [CommentController::class, 'show'])->middleware('auth')->name('commentmes');



Route::get('upload/{path}/{filename}', function($path,$filename)
{
    if(Storage::exists($path.'/'.$filename)){return Storage::download($path.'/'.$filename,'');}


});