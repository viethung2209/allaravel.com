<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
Route::get('/hello-world', function () {
    return view('hello-world');
});
Route::get('/dashboard', function () {
    //Code here
})->middleware('auth', 'checkage');
Route::get('/role', [
    'middleware' => 'role:superadmin',
    'uses' => 'App\Http\Controllers\MainController@checkRole',
]);
Route::group(['middleware' => ['web']], function () {
    //
});
Route::get('/tin-tuc/{news_id_string}',
    'App\Http\Controllers\MainController@showNews');
Route::get('/category/laravel-nang-cao',
    'App\Http\Controllers\MainController@uriTest');
Route::get('user-info', 'App\Http\Controllers\MainController@getUserInfo');
Route::get('contact', 'App\Http\Controllers\ContactController@showContactForm');
Route::post('contact', 'App\Http\Controllers\ContactController@insertMessage');
Route::get('components', function () {
    return view('fontend.component-example');
});
Route::get('first-blade-example', function () {
    return view('fontend.first-blade-example');
});
Route::get('second-blade-example', function () {
    $comment = 'Tôi là <span class="label label-success">All Laravel</span>';
    return view('fontend.second-blade-example')->with('comment', $comment);
});
Route::get('contact', function () {
    if (View::exists('fontend.contact')) {
        return view('fontend.contact');
    } else {
        return 'Trang liên hệ đang bị lỗi, bạn vui lòng quay lại sau';
    }
});
Route::get('news', function () {
    $news_list = array(
        ['title' => 'Bài viết số 1', 'content' => 'Nội dung bài viết 1', 'post_date' => '2017-01-03'],
        ['title' => 'Bài viết số 2', 'content' => 'Nội dung bài viết 2', 'post_date' => '2017-01-03'],
        ['title' => 'Bài viết số 3', 'content' => 'Nội dung bài viết 3', 'post_date' => '2017-01-03'],
        ['title' => 'Bài viết số 4', 'content' => 'Nội dung bài viết 4', 'post_date' => '2017-01-03']
    );
    return view('fontend.news-list')->with(compact('news_list'));
});
//Route::get('register', 'App\Http\Controllers\UserController@showRegisterForm');
//Route::post('register', 'App\Http\Controllers\UserController@storeUser');
Route::resource('admin/product', 'App\Http\Controllers\ProductController',
    ['only' => [
        'create', 'store', 'edit', 'index'
    ],
    'middleware' => 'auth'
]);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', 'App\Http\Controllers\PostController@index');
Route::get('/posts', 'App\Http\Controllers\PostController@index')->name('list_posts');
Route::group(['prefix' => 'posts'], function () {
    Route::get('/drafts', 'App\Http\Controllers\PostController@drafts')
        ->name('list_drafts')
        ->middleware('auth');
    Route::get('/show/{id}', 'App\Http\Controllers\PostController@show')
        ->name('show_post');
    Route::get('/create', 'App\Http\Controllers\PostController@create')
        ->name('create_post')
        ->middleware('can:post.create');
    Route::post('/create', 'App\Http\Controllers\PostController@store')
        ->name('store_post')
        ->middleware('can:post.create');
    Route::get('/edit/{post}', 'App\Http\Controllers\PostController@edit')
        ->name('edit_post')
        ->middleware('can:post.update,post');
    Route::post('/edit/{post}', 'App\Http\Controllers\PostController@update')
        ->name('update_post')
        ->middleware('can:post.update,post');
    Route::get('/publish/{post}', 'App\Http\Controllers\PostController@publish')
        ->name('publish_post')
        ->middleware('can:post.publish');
});

Route::get('user/activation/{token}',
    'App\Http\Controllers\Auth\RegisterController@activateUser')->name('user.activate');

Route::get('/auth/facebook', 'App\Http\Controllers\SocialAuthController@redirectToProvider');
Route::get('/auth/facebook/callback', 'App\Http\Controllers\SocialAuthController@handleProviderCallback');
