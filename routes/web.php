<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleReplyController;
use App\Http\Controllers\Contactform\ContactController;
use App\Http\Controllers\CategorypageController;

use App\Http\Controllers\GuestticketController;
use App\Http\Controllers\User\Ticket\CommentsController;



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

// include('installer.php');


Route::middleware(ProtectAgainstSpam::class)->group(function() {

	Route::middleware(['countrylistbub', 'throttle:refresh', /*'ipblockunblock'*/])->group(function () {

		Route::get('/', [HomeController::class, 'index'])->name('home');
		// Route::get('language/{locale}', [HomeController::class, 'setLanguage'])->name('front.set_language');
		Route::get('/captchareload', [HomeController::class, 'captchareload'])->name('captcha.reload');
		/*Route::get('/article/{id}', [HomeController::class, 'knowledge'])->name('article');
		Route::get('/likes/{id}',[HomeController::class, 'like']);
		Route::get('/dislikes/{id}',[HomeController::class, 'dislike']);
		Route::get('/faq', [HomeController::class, 'faqpage']);
		Route::get('/page/{pageslug}', [HomeController::class, 'frontshow']);

		Route::get('/knowledge', [ArticleCommentController::class, 'index'])->name('knowledge');
		Route::post('/comment{id}', [ArticleCommentController::class, 'store']);
		Route::post('/replies{id}', [ArticleReplyController::class, 'store']);

		Route::get('/contact-us', [ContactController::class, 'contact']);
		Route::post('/contact-us', [ContactController::class, 'saveContact']);

		Route::get('/category/{id}', [CategorypageController::class, 'index']);*/

		Route::get('/guest/ticketdetails/{id}', [GuestticketController::class, 'guestdetails'])->name('guest.gusetticket');
		Route::get('/guest/ticket/{ticket_id}', [GuestticketController::class, 'guestview'])->name('gusetticket');
		Route::delete('/image/delete/{id}', [GuestticketController::class, 'imagedestroy']);
		Route::get('/rating/star5/{id}', [GuestticketController::class, 'star5']);
		Route::get('/rating/star4/{id}', [GuestticketController::class, 'star4']);
		Route::get('/rating/star3/{id}', [GuestticketController::class, 'star3']);
		Route::get('/rating/star2/{id}', [GuestticketController::class, 'star2']);
		Route::get('/rating/star1/{id}', [GuestticketController::class, 'star1']);
		Route::post('envatoverify',[GuestticketController::class, 'envatoverify'])->name('guest.envatoverify');
		Route::post('/guestticket/editcomment/{id}', [CommentsController::class, 'updateedit']);
		// Route::post('/guest/emailsvalidate', [GuestticketController::class, 'emailsvalidateguest'])->name('guest.emailsvalidate');
		Route::get('/rating/{ticket_id}', [GuestticketController::class, 'rating'])->name('guest.rating')->middleware('disablepreventback');
		Route::post('guest/closed/{ticket_id}',[GuestticketController::class, 'close'])->name('guesttickets.ticketclose');
		Route::post('guest/ticket/{ticket_id}',[GuestticketController::class, 'postComment'])->name('guest.comment');
		Route::get('/guest/openticket', [GuestticketController::class, 'index'])->name('guest.ticket');
		Route::post('/guest/openticket', [GuestticketController::class, 'gueststore']);
		Route::post('/guest/storemedia', [GuestticketController::class, 'guestmedia'])->name('guest.imageupload');

	});
	Route::post('/guest/emailsvalidate', [GuestticketController::class, 'emailsvalidateguest'])->name('guest.emailsvalidate');
	Route::post('/guest/verifyotp', [GuestticketController::class, 'verifyotp'])->name('guest.verifyotp');
	Route::post('subcategorylist',[GuestticketController::class, 'subcategorylist'])->name('guest.subcategorylist');
	Route::post('/search',[HomeController::class, 'searchlist']);
	Route::post('/suggestarticle',[HomeController::class, 'suggestarticle']);
	// Route::get('ipblock', [App\Http\Controllers\CaptchaipblockController::class, 'index'])->name('ipblock');
	// Route::post('ipblock/update', [App\Http\Controllers\CaptchaipblockController::class, 'update'])->name('ipblock.update');
	// Route::get('/captchasreload', [App\Http\Controllers\CaptchaipblockController::class, 'captchasreload'])->name('captchas.reload');
	Route::get('/apifailed', [App\Http\Controllers\ApiController::class, 'index'])->name('apifail.index');
});
Route::get('assig', function(){

	$res = app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Envato Access');
	dd($res, auth()->user()->roles);
	// $user = \App\Models\User::find(2);
	// $user->assignRole('admin');
});