<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\SearchController;

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

Route::get('/hello', function () {
    return 'Hello World';
});

Route::match(['get', 'post'], 'foo', function () {
    return 'This is a request from get or post';
});

//路由参数
Route::get('posts/{userid}/username/{username}', function ($userId, $username){
    return 'userID:'.$userId. '-- username: '. $username;
});

//index路由
Route::get('edit/{id}/{action}', [IndexController::class, 'edit']);
Route::get('index', [IndexController::class, 'index']);

//article路由
// Route::get('admin/article/index', [ArticleController::class, 'index']);
// Route::get('admin/article/create', [ArticleController::class, 'create']);
// Route::post('admin/article/store', [ArticleController::class, 'store']);
// Route::get('admin/article/show/{id}', [ArticleController::class, 'show']);
// Route::get('admin/article/edit/{id}', [ArticleController::class, 'edit']);
// Route::put('admin/article/update/{id}', [ArticleController::class, 'update']);
// Route::delete('admin/article/destroy/{id}', [ArticleController::class, 'destroy']);

Route::prefix('admin/article')->group(function (){
    Route::get('index', [ArticleController::class, 'index']);
    Route::get('create', [ArticleController::class, 'create']);
    Route::post('store', [ArticleController::class, 'store']);
    Route::get('show/{id}', [ArticleController::class, 'show']);
    Route::get('edit/{id}', [ArticleController::class, 'edit']);
    Route::put('update/{id}', [ArticleController::class, 'update']);
    Route::delete('destroy/{id}', [ArticleController::class, 'destroy']);
});

Route::resource('products', ProductController::class);

Route::get('search', [SearchController::class, 'index'])->name('search');
Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');


Route::get('importExportView', [MyController::class, 'importExportView']);
Route::get('export', [MyController::class, 'export'])->name('export');
Route::post('import', [MyController::class, 'import'])->name('import');

Route::get('file-upload', [FileUploadController::class, 'fileUpload'])->name('file.upload');

Route::post('file-upload', [FileUploadController::class, 'fileUploadPost'])->name('file.upload.post');

require __DIR__.'/auth.php';
