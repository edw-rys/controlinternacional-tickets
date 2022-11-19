<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'User', 'prefix' => 'customer'], function(){

			

    Route::group(['namespace' => 'Auth'], function(){

        Route::get('/login', 'LoginController@showLoginForm')->middleware('guest:customer')->name('auth.login');
        Route::post('/login', 'LoginController@login')->middleware('guest:customer')->name('client.do_login');
        Route::post('/ajaxlogin', 'LoginController@ajaxlogin')->middleware('guest:customer')->name('client.do_ajaxlogin');

        Route::post('/logout', 'LoginController@logout')->middleware('auth:customer')->name('client.logout');
        
        // Social Auth
        Route::get('/login/{social}', 'LoginController@socialLogin')->name('social.login');
        Route::get('/login/{social}/callback','LoginController@handleProviderCallback')->name('social.login-callback');
    
        Route::get('/register', 'RegisterController@showRegistrationForm')->middleware('guest:customer')->name('auth.register');
        Route::post('/register', 'RegisterController@register')->name('register')->middleware('guest:customer');
        Route::post('/register1', 'RegisterController@registers')->name('register1')->middleware('guest:customer');
        Route::get('/forgotpassword', 'Passwords\ForgotpasswordController@forgot')->middleware('guest:customer');
        Route::post('/forgotpassword', 'Passwords\ForgotpasswordController@Email')->middleware('guest:customer');
        Route::post('/forgotpasswordajax', 'Passwords\ForgotpasswordController@Emailajax')->name('ajax.forgot')->middleware('guest:customer');
        Route::post('/change-password', 'ChangepasswordController@changepassword')->name('change.password');
        Route::get('/{token}/reset-password', 'Passwords\ResetpasswordController@resetpassword')->middleware('guest:customer')->name('reset.password');
        Route::post('/reset-password',  'Passwords\ResetpasswordController@updatePassword')->middleware('guest:customer');
        Route::get('/user/verify/{token}','RegisterController@verifyUser')->middleware('guest:customer')->name('verify.email');
    });

    Route::middleware('auth:customer','customer.auth')->group(function () {

        Route::get('/mark-as-read', 'DashboardController@markNotification')->name('customer.markNotification');
        Route::get('/', 'DashboardController@userTickets')->name('client.dashboard');
        Route::get('/profile','Profile\UserprofileController@profile')->name('client.profile');
        Route::post('/profile','Profile\UserprofileController@profilesetup')->name('client.profilesetup');
        Route::post('/deleteaccount/{id}','Profile\UserprofileController@profiledelete')->name('client.profiledelete');
        Route::delete('/image/remove/{id}', 'Profile\UserprofileController@imageremove');
        Route::post('/custsettings', 'Profile\UserprofileController@custsetting');
        Route::get('/ticket','Ticket\TicketController@create')->name('client.ticket');
        Route::post('/ticket','Ticket\TicketController@store')->name('client.ticketcreate');
        Route::post('/imageupload','Ticket\TicketController@storeMedia')->name('imageupload');
        Route::get('/ticket/view/{ticket_id}','Ticket\TicketController@show')->name('loadmore.load_data');
        Route::post('/ticket/{ticket_id}','Ticket\CommentsController@postComment')->name('client.comment');
        Route::post('/ticket/imageupload/{ticket_id}','Ticket\CommentsController@storeMedia')->name('client.ticket.image');
        Route::get('/ticket/delete/{id}','Ticket\TicketController@destroy')->name('client.ticket.delete');
        Route::post('/ticket/delete/tickets', 'Ticket\TicketController@ticketmassdestroy')->name('ticket.massremove');
        Route::post('/ticket/editcomment/{id}','Ticket\CommentsController@updateedit')->name('client.comment.edit');
        Route::get('/activeticket','Ticket\TicketController@activeticket')->name('activeticket');
        Route::get('/closedticket','Ticket\TicketController@closedticket')->name('closedticket');
        Route::get('/onholdticket','Ticket\TicketController@onholdticket')->name('onholdticket');
        Route::post('/closed/{ticket_id}','Ticket\TicketController@close')->name('client.ticketclose');
        Route::delete('/image/delete/{id}','Ticket\CommentsController@imagedestroy')->name('client.imagedestroy');
        Route::post('subcat','Ticket\TicketController@sublist')->name('subcat');
        Route::get('/rating/{ticket_id}', 'Ticket\TicketController@rating')->name('rating')->middleware('disablepreventback');
        Route::get('/rating/star5/{id}', 'Ticket\TicketController@star5');
        Route::get('/rating/star4/{id}', 'Ticket\TicketController@star4');
        Route::get('/rating/star3/{id}', 'Ticket\TicketController@star3');
        Route::get('/rating/star2/{id}', 'Ticket\TicketController@star2');
        Route::get('/rating/star1/{id}', 'Ticket\TicketController@star1');
        Route::get('/generalsetting', 'GeneralSettingController@index')->name('client.general');
        Route::post('/general/notification', 'GeneralSettingController@NotifyOn')->name('client.generalsetting');
        Route::get('/notification', 'DashboardController@notify')->name('client.notification');
        
        Route::get('/markAsRead', function(){

            $notify = Auth::guard('customer')->user();
            $notify->unreadNotifications->markAsRead();
        
        })->name('cust.mark');
    });

});