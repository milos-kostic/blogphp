<?php

use Illuminate\Support\Facades\Route;

// Recaptcha:
// source:
// https://www.nicesnippets.com/blog/laravel-8-google-recaptcha-v3-example-tutorial
//
//use App\Http\Controllers\GoogleV3CaptchaController;
//Route::get('google-v3-recaptcha', [GoogleV3CaptchaController::class, 'index']);
//Route::post('validate-g-recaptcha', [GoogleV3CaptchaController::class, 'validateGCaptch']);
/* * ******* */


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


// File Manager: 
// source:
// https://stackoverflow.com/questions/60434252/laravel-ckeditor-laravel-file-manager-do-not-display-images
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});



Route::get('/', 'App\Http\Controllers\IndexController@index')->name('front.index.index');



Route::get('/blog', 'App\Http\Controllers\PostsController@index')->name('front.posts.index');
Route::get('/blog/{post}/{seoSlug?}', 'App\Http\Controllers\PostsController@single')->name('front.posts.single');


// // *************
Route::get('/categoriy/{category}/{seoSlug?}', 'App\Http\Controllers\PostsController@category')->name('front.posts.category');

// // *************
Route::get('/tag/{tag}/{seoSlug?}', 'App\Http\Controllers\PostsController@tag')->name('front.posts.tag');

// // *************
Route::get('/author/{user}/{seoSlug?}', 'App\Http\Controllers\PostsController@user')->name('front.posts.author');

// // *************
Route::post('/blog-search', 'App\Http\Controllers\PostsController@blogSearch')->name('front.posts.search');
Route::get('/search/', 'App\Http\Controllers\PostsController@search')->name('front.posts.search');







/* * ********************* AJAX COMMENTS RUTE ****************** */
Route::get('/front-comments', 'App\Http\Controllers\CommentsController@index')->name('front.front_comments.index');

Route::post('/front-comments/content', 'App\Http\Controllers\CommentsController@content')->name('front.front_comments.content');


Route::post('/comments/add', 'App\Http\Controllers\CommentsController@add')->name('front.front_comments.add');

Route::get('/front-comments/table', 'App\Http\Controllers\CommentsController@table')->name('front.front_comments.table');

Route::get('/front-comments/comments-by-post', 'App\Http\Controllers\CommentsController@commentsByPost')->name('front.front_comments.comments_by_post');
/* * *************************************** */




// ******** CHECKOUT CONTROLLER RUTE **********/
Route::prefix('/checkout')->group(function() {

    Route::get('/', 'App\Http\Controllers\CheckoutController@index')->name('front.checkout.index');
    Route::get('/details', 'App\Http\Controllers\CommentsController@details')->name('front.comments.details');
});





/* * ********** CONTACT RUTE *************** */
Route::get('/contact', 'App\Http\Controllers\ContactController@index')->name('front.contact.index');
Route::post('/contact/send-message', 'App\Http\Controllers\ContactController@sendMessage')->name('front.contact.send_message');
/* * *************************************** */






// Auth::routes();
Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('front.auth.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');




// Auth::routes();

Auth::routes();

Route::middleware('auth')->prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function() {

    Route::get('/', 'IndexController@index')->name('admin.index.index');



    //  IZDVAJAMO KONTROLERE SA PREFIKSOM TAGS
    Route::prefix('/tags')->group(function() {

        Route::get('/', 'TagsController@index')->name('admin.tags.index');

        Route::get('/add', 'TagsController@add')->name('admin.tags.add');

        Route::post('/insert', 'TagsController@insert')->name('admin.tags.insert');


        Route::get('/edit/{tag}', 'TagsController@edit')->name('admin.tags.edit');
        Route::post('/update/{tag}', 'TagsController@update')->name('admin.tags.update');

        Route::post('/delete', 'TagsController@delete')->name('admin.tags.delete');
    });






    //  IZDVAJAMO KONTROLERE SA PREFIKSOM COMMENTS
    Route::prefix('/comments')->group(function() {

        Route::get('/', 'CommentsController@index')->name('admin.comments.index');

        Route::get('/add', 'CommentsController@add')->name('admin.comments.add');
        Route::post('/insert', 'CommentsController@insert')->name('admin.comments.insert');

        Route::get('/edit/{comment}', 'CommentsController@edit')->name('admin.comments.edit');
        Route::post('/update/{comment}', 'CommentsController@update')->name('admin.comments.update');

        Route::post('/datatable', 'CommentsController@datatable')->name('admin.comments.datatable');

        Route::post('/disable', 'CommentsController@disable')->name('admin.comments.disable');
        Route::post('/enable', 'CommentsController@enable')->name('admin.comments.enable');

        Route::post('/delete', 'CommentsController@delete')->name('admin.comments.delete');
    });





    // IZDVAJAMO KONTROLERE SA PREFIKSOM CATEGORIES
    Route::prefix('/categories')->group(function() {

        Route::get('/', 'CategoriesController@index')->name('admin.categories.index');

        Route::get('/add', 'CategoriesController@add')->name('admin.categories.add');

        Route::post('/insert', 'CategoriesController@insert')->name('admin.categories.insert');
        Route::get('/edit/{category}', 'CategoriesController@edit')->name('admin.categories.edit');
        Route::post('/update/{category}', 'CategoriesController@update')->name('admin.categories.update');


        Route::post('/delete', 'CategoriesController@delete')->name('admin.categories.delete');

        Route::post('/change-priorities', 'CategoriesController@changePriorities')->name('admin.categories.change_priorities');
    });



    // IZDVAJAMO KONTROLERE SA PREFIKSOM SLIDES
    Route::prefix('/slides')->group(function() {

        Route::get('/', 'SlidesController@index')
                ->name('admin.slides.index');

        Route::get('/add', 'SlidesController@add')->name('admin.slides.add');

        Route::post('/insert', 'SlidesController@insert')->name('admin.slides.insert');


        Route::get('/edit/{slide}', 'SlidesController@edit')->name('admin.slides.edit');
        Route::post('/update/{slide}', 'SlidesController@update')->name('admin.slides.update');

        Route::post('/delete', 'SlidesController@delete')->name('admin.slides.delete');

        Route::post('/change-priorities', 'SlidesController@changePriorities')->name('admin.slides.change_priorities');


        Route::post('/disable', 'SlidesController@disable')->name('admin.slides.disable');
        Route::post('/enable', 'SlidesController@enable')->name('admin.slides.enable');

        Route::post('/delete-photo/{slide}', 'SlidesController@deletePhoto')->name('admin.slides.delete_photo');
    });




    //  IZDVAJAMO KONTROLERE SA PREFIKSOM USERS
    Route::prefix('/users')->group(function() {

        Route::get('/', 'UsersController@index')->name('admin.users.index');

        Route::get('/add', 'UsersController@add')->name('admin.users.add');
        Route::post('/insert', 'UsersController@insert')->name('admin.users.insert');

        Route::get('/edit/{user}', 'UsersController@edit')->name('admin.users.edit');
        Route::post('/update/{user}', 'UsersController@update')->name('admin.users.update');

        Route::post('/delete', 'UsersController@delete')->name('admin.users.delete');

        Route::post('/disable', 'UsersController@disable')->name('admin.users.disable');
        Route::post('/enable', 'UsersController@enable')->name('admin.users.enable');

        Route::post('/delete-photo/{user}', 'UsersController@deletePhoto')->name('admin.users.delete_photo');

        Route::post('/datatable', 'UsersController@datatable')->name('admin.users.datatable');
    });



    // IZDVAJAMO KONTROLERE SA PREFIKSOM profile
    Route::prefix('/profile')->group(function() {

        Route::get('/edit', 'ProfileController@edit')->name('admin.profile.edit');
        Route::post('/update', 'ProfileController@update')->name('admin.profile.update');

        // DELETE-PHOTO
        Route::post('/delete-photo', 'ProfileController@deletePhoto')
                ->name('admin.profile.delete_photo');

        // CHANGE-PASSWORD:
        Route::get('/change-password', 'ProfileController@changePassword')->name('admin.profile.change_password'); // za prikaz forme
        Route::post('/change-password', 'ProfileController@changePasswordConfirm')->name('admin.profile.change_password_confirm'); // za obradu forme
    });



    // IZDVAJAMO KONTROLERE SA PREFIKSOM POSTS
    // GORE IMA PRVI SAMOSTALNI SA PREFIKSON blogs
    Route::prefix('/posts')->group(function() {

        Route::get('/', 'PostsController@index')->name('admin.posts.index');

        Route::get('/add', 'PostsController@add')->name('admin.posts.add');
        Route::post('/insert', 'PostsController@insert')->name('admin.posts.insert');

        Route::get('/edit/{post}', 'PostsController@edit')->name('admin.posts.edit');
        Route::post('/update/{post}', 'PostsController@update')->name('admin.posts.update');

        Route::post('/delete', 'PostsController@delete')->name('admin.posts.delete');

        Route::post('/delete-photo/{post}', 'PostsController@deletePhoto')->name('admin.posts.delete_photo');

        Route::post('/datatable', 'PostsController@datatable')->name('admin.posts.datatable');

        Route::post('/disable', 'PostsController@disable')->name('admin.posts.disable');
        Route::post('/enable', 'PostsController@enable')->name('admin.posts.enable');

        Route::post('/unimportant', 'PostsController@unimportant')->name('admin.posts.unimportant');
        Route::post('/important', 'PostsController@important')->name('admin.posts.important');
    });
});
