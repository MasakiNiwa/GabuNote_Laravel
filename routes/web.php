<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentsController;

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

Route::get('/', function(){
    return view('main');
});

//レコードリストエリア
Route::post('contents/view/recent_records', [ContentsController::class, 'show_recent_records'])->name('recent_records_view');
//グラフエリア
Route::post('contents/folder_chart', [ContentsController::class, 'folder_chart'])->name('folder_chart');
Route::post('contents/record_chart', [ContentsController::class, 'record_chart'])->name('record_chart');
//学習フォルダメニューエリア
Route::post('contents/show_ancestor_folders', [ContentsController::class, 'show_ancestor_folders'])->name('show_ancestor_folders');
Route::post('contents/show_folder_name', [ContentsController::class, 'show_folder_name'])->name('show_folder_name');
Route::post('contents/update_folder', [ContentsController::class, 'update_folder'])->name('update_folder');
//子学習フォルダエリア
Route::post('contents/new_folder', [ContentsController::class, 'new_folder'])->name('new_folder');
Route::post('contents/view/totaltime', [ContentsController::class, 'show_total_time'])->name('total_time_view');
Route::post('contents/view/childfolder', [ContentsController::class, 'show_child_folder'])->name('child_folder_view');
Route::post('contents/delete_folder', [ContentsController::class, 'delete_folder'])->name('delete_folder');
//子学習レコードエリア
Route::post('contents/view/achievement', [ContentsController::class, 'show_achievement'])->name('achievement_view');
Route::post('contents/view/childrecord', [ContentsController::class, 'show_child_record'])->name('child_record_view');
Route::post('contents/delete_record', [ContentsController::class, 'delete_record'])->name('delete_record');
Route::post('contents/get_record_info', [ContentsController::class, 'get_record_info'])->name('get_record_info');
//レコード編集エリア
Route::post('contents/save_record', [ContentsController::class, 'save_record'])->name('save_record');