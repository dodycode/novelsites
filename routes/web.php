<?php

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

// CLI Commands
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect()->to(route('index'));
});

Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate:refresh', [
    '--seed' => true,
	]);
    return redirect()->to(route('index'));
});

// Front End
Route::prefix('/')->group(function() {
	Route::get('/', 'FrontEndController@index')->name('index');
	Route::get('/user/activation/{token}', 'Auth\RegisterController@userActivation')->name('index.activation');
	Route::get('/novel', function() {
		return redirect()->to(route('index.novel.list'));
	});
	Route::get('/novels', function() {
		return redirect()->to(route('index.novel.list'));
	});
	Route::get('/fantranslation', function() {
		return redirect()->to(route('index.novel.ft'));
	});
	Route::get('/novel/{slug}', 'FrontEndController@detailNovel')->name('index.novel');

	// Rating System
	Route::get('/novel/{slug}/bad', 'UserController@badRate')->name('index.novel.rate.bad');
	Route::get('/novel/{slug}/neutral', 'UserController@neutralRate')->name('index.novel.rate.neutral');
	Route::get('/novel/{slug}/amazing', 'UserController@amazingRate')->name('index.novel.rate.amazing');

	// Add to Favorite
	Route::get('/novel/{slug}/favorit', 'UserController@addFavorite')->name('index.novel.favorit.add');
	Route::get('/novel/{slug}/removefavorit', 'UserController@removeFavorite')->name('index.novel.favorit.remove');

	// Comments
	Route::post('/novel/{slug}/tulisreview', 'UserController@makeReview')->name('index.novel.comment');
	Route::post('/novel/editreview/{id}', 'UserController@editReview')->name('index.novel.comment.edit');
	Route::get('/novel/deletereview/{id}', 'UserController@deleteReview')->name('index.novel.comment.delete');

	// Novel List
	Route::get('/novellist/{orderby?}/{order?}', 'FrontEndController@novels')->name('index.novel.list');

	// FT List
	Route::get('/fantranslations/{orderby?}/{order?}', 'FrontEndController@ft')->name('index.novel.ft');
	Route::get('/fantranslation/{slug}', 'FrontEndController@ftdetail')->name('index.ft.detail');

	// Likes FT
	Route::get('/fantranslation/{slug}/like', 'UserController@addLike')->name('index.ft.like.add');
	Route::get('/fantranslation/{slug}/removelike', 'UserController@removeLike')->name('index.ft.like.remove');

	// Sitemap
	Route::get('/sitemap', 'SitemapController@index')->name('index.sitemap');

	// filternovel
	Route::get('/novels/{filtertipe}/{slug}/{orderby?}/{order?}', 'FrontEndController@filterNovel')->name('index.filter');
});

 // Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@loginUser')->name('login.submit');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register.submit');

// User Inviation
Route::get('/daftar/{token}', 'registerAdmin@processRegistration')->name('invite.register');
Route::post('/daftar/{token}', 'registerAdmin@storeRegistration')->name('invite.store');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::prefix('home')->group(function() {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/addft', 'HomeController@ft')->name('home.ft');
	Route::post('/addft', 'HomeController@storeFT')->name('home.ft.submit');
	Route::get('/addnovel', 'HomeController@novel')->name('home.novel');
	Route::post('/addnovel', 'HomeController@storeNovel')->name('home.novel.submit');
	Route::get('/addchapter', 'HomeController@chapters')->name('home.chapter');
	Route::post('/addchapter', 'HomeController@storeChapter')->name('home.chapter.submit');
	Route::get('/userprofil', 'HomeController@profil')->name('home.profil');
	Route::post('/userprofil', 'HomeController@ubahPP')->name('home.profil.pp');
	Route::get('/listrequest', 'HomeController@listRequestJoin')->name('home.listrequest');
	Route::get('/listrequest/accept/{namaft}', 'HomeController@acceptRequest')->name('home.listrequest.accept');
	Route::get('/listrequest/tolak/{namaft}', 'HomeController@declineRequest')->name('home.listrequest.decline');
});

Route::prefix('adminpeg')->group(function() {
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.home');

	// Genres
	Route::get('/genre', 'AdminController@genres')->name('admin.genre');
	Route::get('/genre/add', 'AdminController@addGenres')->name('admin.genre.add');
	Route::post('/genre/add', 'AdminController@storeGenres')->name('admin.genre.submit');
	Route::get('/genre/edit/{id}', 'AdminController@editGenres')->name('admin.genre.edit');
	Route::post('/genre/edit/{id}', 'AdminController@storeEditedGenre')->name('admin.genre.submitEdit');
	Route::get('/genre/delete/{id}', 'AdminController@deleteGenre')->name('admin.genre.delete');

	// Types
	Route::get('/tipenovel', 'AdminController@types')->name('admin.tipenovel');
	Route::get('/tipenovel/add', 'AdminController@addTypes')->name('admin.tipenovel.add');
	Route::post('/tipenovel/add', 'AdminController@storeTypes')->name('admin.tipenovel.submit');
	Route::get('/tipenovel/edit/{id}', 'AdminController@editTypes')->name('admin.tipenovel.edit');
	Route::post('/tipenovel/edit/{id}', 'AdminController@storeEditedType')->name('admin.tipenovel.storeEdit');
	Route::get('/tipenovel/delete/{id}', 'AdminController@deleteType')->name('admin.tipenovel.delete');

	// Novels
	Route::get('/novel', 'AdminController@novels')->name('admin.novel');
	Route::get('/novel/add', 'AdminController@addNovel')->name('admin.novel.add');
	Route::post('/novel/add', 'AdminController@storeNovel')->name('admin.novel.submit');
	Route::get('/novel/edit/{id}', 'AdminController@editNovel')->name('admin.novel.edit');
	Route::post('/novel/edit/{id}', 'AdminController@storeEditedNovel')->name('admin.novel.storeEdit');
	Route::get('/novel/hapus/{id}', 'AdminController@deleteNovel')->name('admin.novel.delete');

	// Chapters
	Route::get('/chapter', 'AdminController@chapters')->name('admin.chapter');
	Route::get('/chapter/add', 'AdminController@addChapter')->name('admin.chapter.add');
	Route::post('/chapter/add', 'AdminController@storeChapter')->name('admin.chapter.submit');
	Route::get('/chapter/edit/{id}', 'AdminController@editChapter')->name('admin.chapter.edit');
	Route::post('/chapter/edit/{id}', 'AdminController@storeEditedChapter')->name('admin.chapter.storeEdit');
	Route::get('/chapter/hapus/{id}', 'AdminController@deleteChapter')->name('admin.chapter.delete');

	// Fan Translations
	Route::get('/fantranslations', 'AdminController@fantranslations')->name('admin.ft');
	Route::get('/fantranslations/add', 'AdminController@addFT')->name('admin.ft.add');
	Route::post('/fantranslations/add', 'AdminController@storeFT')->name('admin.ft.submit');
	Route::get('/fantranslations/edit/{id}', 'AdminController@editFT')->name('admin.ft.edit');
	Route::post('/fantranslations/edit/{id}', 'AdminController@storeEditedFT')->name('admin.ft.storeEdit');
	Route::get('/fantranslations/hapus/{id}', 'AdminController@deleteFT')->name('admin.ft.delete');

	// Staff
	Route::get('/staff', 'AdminController@staff')->name('admin.staff');
	Route::get('/staff/add', 'AdminController@addStaff')->name('admin.staff.add');
	Route::post('/staff/add', 'AdminController@storeStaff')->name('admin.staff.submit');
	Route::get('/staff/pecat/{id}', 'AdminController@pecatStaff')->name('admin.staff.pecat');

	// Permintaan Pembuatan FT
	Route::get('/listrequest', 'AdminController@listRequestJoin')->name('admin.requestjoin');
	Route::get('/listrequest/terimaft/{namaft}', 'AdminController@acceptRequest')->name('admin.requestjoin.accept');
	Route::get('/listrequest/tolak/{namaft}', 'AdminController@declineRequest')->name('admin.requestjoin.decline');

	// Invite Admin
	Route::get('/invites', 'AdminController@getInviteList')->name('admin.invite');
	Route::get('/invite/add', 'AdminController@createInvite')->name('admin.invite.add');
	Route::post('/invite/add', 'AdminController@processInvite')->name('admin.invite.submit');

	// Password Reset
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});


