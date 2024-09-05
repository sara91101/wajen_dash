<?php
use App\Http\Controllers\QuestionController;

use App\Http\Controllers\FaqController;
use App\Http\Controllers\PrivacyFirstController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BlogDepartmentController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\InquiryController;
use App\Models\BlogDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/apiFaqs', [FaqController::class, 'apiFaqs'])->name('apiFaqs');
Route::get('/privacies', [PrivacyFirstController::class, 'index'])->name('privacies');
Route::get('/apiActivities', [ActivityController::class, 'apiActivities'])->name('apiActivities');
//Route::post('/subscribers/register', [CustomerController::class, 'subscribersRegister'])->name('subscribersRegister');

Route::post('/sendToEmail', [QuestionController::class, 'sendToEmail'])->name('sendToEmail');

Route::post('/v2/inquiries', [InquiryController::class, 'store']);
Route::post('/v2/distributors', [DistributorController::class, 'store']);
Route::post('/v2/friends', [FriendController::class, 'store']);
Route::get('/v2/activityList', [ActivityController::class, 'activityList']);

Route::get('/v2/blogDepartmentList', [BlogDepartmentController::class, 'blogDepartmentList']);
Route::get('/v2/blogs/{dept_id}', [BlogDepartmentController::class, 'blogs']);
Route::get('/v2/blog/{blog_id}', [BlogsController::class, 'show']);


