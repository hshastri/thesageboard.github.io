<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/crm/login', 'Crm\HomeController@login')->name('crm.login');
Route::post('/crm/authenticated', 'Crm\HomeController@authenticated')->name('crm.authenticated');

Route::group(['prefix' =>'crm', 'namespace'=>'Crm', 'middleware' => ['auth', 'admin']], function(){

     Route::get('logout', 'HomeController@logout')->name('crm.logout');
	 Route::get('dashboard', 'HomeController@index')->name('crm.dashboard');
	 Route::get('user-feedback', 'HomeController@show_feedback')->name('crm.user-feedback');
	 Route::resource('category', 'CategoryController');


	 Route::resource('subcategory', 'SubCategoryController');
	 Route::resource('tags', 'TagsController');
	 Route::post('get_subcategories_by_category', 'HomeController@get_subcategories_by_category')->name('get_subcategories_by_category');
	 Route::resource('question', 'QuestionController');
	 Route::resource('users', 'UserController');
     Route::resource('badge', 'BadgeController');
	 Route::resource('invite', 'InviteUserController');
	 Route::get('users/reinvite/{id}', 'InviteUserController@reinvite')->name('users.reinvite');

	 Route::get('ask-question', 'QuestionController@ask_question')->name('crm.ask-question');
	 Route::delete('softdelete/{id}', 'QuestionController@soft_delete')->name('crm.softdelete');
	 Route::get('questions.details/{id}', 'QuestionController@ask_question_details')->name('crm.questions.details');

	Route::get('withdrawal-requests', 'WithdrawController@index')->name('crm.withdrawal-requests');

    Route::get('transaction', 'PaymentController@transaction')->name('crm.transaction');
    Route::get('transaction.details/{id}', 'PaymentController@transaction_details')->name('crm.transaction.details');


	 Route::match(['GET','POST'],'payment_settings', 'BasicSettingsController@payment_settings')->name('crm.payment_settings');
	 Route::match(['GET','POST'],'business_settings', 'BasicSettingsController@business_settings')->name('crm.business_settings');
	 Route::match(['GET','POST'],'policy_settings', 'BasicSettingsController@policy_settings')->name('crm.policy_settings');

    Route::get('refund-requests', 'WithdrawController@refund_request')->name('crm.refund-requests');
    Route::get('refund-details/{qid}/{uid}/{eid}/{rid}', 'WithdrawController@refund_details')->name('crm.refund-details');

    Route::match(['GET','POST'],'release-refund/{rid}', 'WithdrawController@release_refund')->name('release-refund');
    Route::match(['GET','POST'],'suspend-refund/{rid}', 'WithdrawController@suspend_refund')->name('suspend-refund');

    Route::post('chat', 'HomeController@chat')->name('crm.chat');
});
