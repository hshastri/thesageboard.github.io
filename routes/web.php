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



Route::group(['namespace'=>'Frontend'], function(){

    Route::get('/', 'HomeController@index')->name('/');
    Route::post('home/load_question', 'HomeController@load_home_question_section')->name('home.load_question');
    Route::match(['GET','POST'],'register', 'HomeController@register')->name('register');
    Route::get('sage/{id}', 'ReferralController@refer_user')->name('sage');

    /* Route::match(['GET','POST'],'expert-register', 'HomeController@expert_register')->name('expert-register');*/
    Route::get('login', 'HomeController@login')->name('login');
    Route::get('test-login', 'HomeController@test_login')->name('test');
    Route::post('authenticated', 'HomeController@authenticated')->name('authenticated');

    Route::match(['GET','POST'],'forget-password', 'HomeController@forget_password')->name('forget-password');
    Route::match(['GET','POST'],'verify_otp', 'HomeController@verify_otp')->name('verify_otp');
    Route::match(['GET','POST'],'change_password', 'HomeController@change_password')->name('change_password');

    Route::get('questions', 'AskQuestionController@questions')->name('questions');
    Route::get('show-question/{cat}', 'AskQuestionController@filterFromCrousal')->name('show-question');
    Route::get('question-details/{id}/{slug?}',"AskQuestionController@question_details")->name('question-details');

    Route::post('widget_question_load',"HomeController@widget_question_load")->name('widget_question_load');
    Route::post('widget_expert_load',"HomeController@widget_expert_load")->name('widget_expert_load');
    Route::post('prepoulated_tags',"HomeController@prepoulated_tags")->name('prepoulated_tags');
    Route::post('populated-subcategory',"HomeController@populated_subcategory")->name('populated-subcategory');

    //
    Route::match(['GET','POST'],'expert-register', 'UserController@registration')->name('expert-register');
    Route::get('users', 'UserController@users')->name('users');
    Route::get('listings', 'HomeController@listings')->name('listings');
    Route::get('privacy-policy', 'HomeController@terms_conditions')->name('policy');
    Route::get('terms-and-conditions', 'HomeController@terms_service')->name('terms-and-conditions');

    Route::get('/social-login/redirect/{provider}/{point?}', 'LoginController@redirectToProvider')->name('social.login');
    Route::get('/social-login/{provider}/callback', 'LoginController@handleProviderCallback')->name('social.callback');

    Route::post('keysearch', 'AskQuestionController@keysearch')->name('keysearch');
    Route::get('filter-topic/{id}', 'AskQuestionController@filter_topic')->name('filter-topic');
    Route::get('filter-subtopic/{id}', 'AskQuestionController@filter_subtopic')->name('filter-subtopic');
    Route::get('filter-title/{title}', 'AskQuestionController@filter_title')->name('filter-title');

    Route::get('load-question-comment/{id}', 'CommentController@load_question_comment')->name('load-question-comment');
    Route::get('load-ans-comment/{id}', 'CommentController@load_ans_comment')->name('load-ans-comment');
    Route::get('user-profile/{id}', 'UserController@user_profile')->name('user-profile');


    Route::group(['middleware' => ['auth', 'user']], function(){

        Route::get('logout', 'HomeController@logout')->name('logout');

        Route::match(['GET','POST'],'expert-bio', 'UserController@bio_info')->name('expert-bio');
        Route::match(['GET','POST'],'add-expertise', 'UserController@add_expertise')->name('add-expertise');

        Route::get('fetch-topic', 'UserController@fetch_topic')->name('fetch-topic');
        Route::post('get-subtopic', 'UserController@get_subtopic')->name('get-subtopic');
        Route::post('get-tags', 'UserController@get_tags')->name('get-tags');

        Route::match(['GET','POST'],'topic-valuation', 'UserController@topic_valuation')->name('topic-valuation');

        Route::post('ask-question', 'AskQuestionController@index')->name('ask-question');
        Route::post('get-single-sub', 'AskQuestionController@get_single_subcategory')->name('get-single-sub');

        Route::match(['GET','POST'],'question-edit/{id}', 'AskQuestionController@edit_question')->name('question-edit');
        Route::match(['GET','POST'],'answer-edit/{id}', 'AskQuestionController@edit_answer')->name('answer-edit');
        Route::match(['GET','POST'],'get-answer-edit/{id}', 'AskQuestionController@get_edit_answer')->name('get-answer-edit');

        /*Route::match(['GET','POST'],'realiable-yes/{id}', 'AskQuestionController@realiable_yes')->name('realiable-yes');
        Route::match(['GET','POST'],'question-type/{id}', 'AskQuestionController@question_type')->name('question-type');*/

        Route::match(['GET','POST'],'chosen-expert/{id}', 'AskQuestionController@chosen_expert')->name('chosen-expert');
        Route::get('/realiable-no/{id}', 'AskQuestionController@realiable_no')->name('realiable-no');
        Route::post('answer/{id}', 'AskQuestionController@answer')->name('answer');
        Route::post('private-answer/{id}', 'AskQuestionController@private_answer')->name('private-answer');
        Route::post('comment/{id}', 'AskQuestionController@comment')->name('comment');
        Route::get('change-type/{id}', 'AskQuestionController@change_type')->name('change-type');
        Route::get('ask-question', 'AskQuestionController@index')->name('ask-question');
        Route::post('image-upload', 'AskQuestionController@image_upload')->name('upload');
        Route::get('user-question-details/{qid}/{uid}',"AskQuestionController@private_question_details")->name('user-question-details');

        Route::get('vote-question/{id}/{type}', 'VoteController@vote_question')->name('vote-question');
        Route::get('vote-answer/{id}/{type}', 'VoteController@vote_answer')->name('vote-answer');
        Route::get('vote-comment/{id}/{type}', 'VoteController@vote_comment')->name('vote-comment');
        Route::get('accept-answer/{id}',"VoteController@accepted_answer")->name('accept-answer');
        Route::get('private-answer-accept/{qid}/{eid}/{cid}',"VoteController@private_accepted_answer")->name('private-answer-accept');


        Route::get('user-profile/{id}', 'UserController@user_profile')->name('user-profile');
        Route::get('profile/{id}', 'UserController@my_profile')->name('profile');

        Route::get('user-dashboard', 'UserController@user_deshboard')->name('user-deshboard');
        Route::get('expert-zone', 'UserController@expert_zone')->name('expert-zone');

        Route::match(['GET','POST'],'profile-edit', 'UserController@profile_edit')->name('profile-edit');
        Route::match(['GET','POST'],'expertise', 'UserController@expertise')->name('expertise');

        Route::get('user-activity', 'UserController@user_activity')->name('user-activity');
        Route::get('user-answer', 'UserController@user_answer')->name('user-answer');
        Route::get('score-allocation', 'UserController@score_allocation')->name('score-allocation');

        Route::get('wallet', 'WalletController@user_wallet')->name('wallet');
        Route::get('in-progress', 'WalletController@in_progress')->name('in-progress');
        Route::get('balance', 'WalletController@user_balance')->name('balance');
        Route::get('earnings', 'WalletController@user_earnings')->name('earnings');
        Route::get('costs', 'WalletController@user_costs')->name('costs');
        Route::match(['GET','POST'],'payment-settings', 'WalletController@payment_setting')->name('payment-settings');
        Route::post('setup-payment', 'WalletController@setup_payment')->name('setup-payment');

        Route::get('disbursement', 'WithdrawController@disbursement')->name('disbursement');
        Route::match(['GET','POST'],'get-paid', 'WithdrawController@get_paid')->name('get-paid');

        Route::get('refund', 'RefundController@index')->name('refund');
        Route::match(['GET','POST'],'make-refund/{qid}/{eid}', 'RefundController@make_refund')->name('make-refund');
        Route::match(['GET','POST'],'claim', 'RefundController@claim')->name('claim');
        Route::match(['GET','POST'],'chat-admin/{rid}', 'RefundController@chat_admin')->name('chat-admin');
        Route::post('chat', 'HomeController@chat')->name('chat');

        Route::post('feedback', 'HomeController@feedback')->name('feedback');

        Route::get('my-referral', 'ReferralController@my_referral')->name('referral');
        Route::get('referral-status', 'ReferralController@referral_status')->name('referral-status');
        Route::match(['GET','POST'],'send-invitation', 'ReferralController@send_invitation')->name('send-invitation');
        Route::get('referel-history', 'ReferralController@referel_payments')->name('referel-history');

        Route::match(['GET','POST'],'/social-login-confirmation', 'LoginController@social_login_confirmation')->name('login-confirmation');
        Route::get('check-username', 'UserController@checkUsername')->name('check-username');

        Route::post('question-comment/{id}', 'CommentController@add_question_comment')->name('question-comment');
        Route::post('question-child-comment/{id}', 'CommentController@add_question_child_comment')->name('question-child-comment');
        Route::post('question-sub-child-comment/{id}', 'CommentController@add_question_sub_child_comment')->name('question-sub-child-comment');

        Route::post('edit-qsn-child-comment/{id}', 'CommentController@edit_question_child_comment')->name('edit-qsn-child-comment');
        Route::post('edit-sub-child-comment/{id}', 'CommentController@edit_sub_child_comment')->name('edit-sub-child-comment');
        Route::post('edit-qsn-sub-child-comment/{id}', 'CommentController@edit_question_child_sub_comment')->name('edit-qsn-sub-child-comment');

        Route::post('ans-child-comment/{id}/{ansId}', 'CommentController@add_ans_child_comment')->name('ans-child-comment');

        Route::post('edit-answer-child-comment/{id}', 'CommentController@edit_ans_child_comment')->name('edit-answer-child-comment');
        Route::post('edit-answer-sub-child-comment/{id}', 'CommentController@edit_ans_subchild_comment')->name('edit-answer-sub-child-comment');
        Route::post('edit-sub-sub-child-comment/{id}', 'CommentController@edit_sub_subchild_comment')->name('edit-sub-sub-child-comment');

        Route::get('delete-qsn-child-comment/{id}', 'CommentController@delete_qsn_child_comment')->name('delete-qsn-child-comment');
        Route::get('delete-qsn-sub-comment/{id}', 'CommentController@delete_qsn_sub_comment')->name('delete-qsn-sub-comment');
        Route::get('delete-qsn-sub-child-comment/{id}', 'CommentController@delete_qsn_sub_child_comment')->name('delete-qsn-sub-child-comment');


        Route::get('delete-answer-child-comment/{id}', 'CommentController@delete_ans_child_comment')->name('delete-answer-child-comment');
        Route::get('delete-answer-sub-child-comment/{id}', 'CommentController@delete_ans_sub_child_comment')->name('delete-answer-sub-child-comment');
        Route::get('delete-sub-sub-child-comment/{id}', 'CommentController@delete_sub_sub_child_comment')->name('delete-sub-sub-child-comment');

        Route::get('unseen', 'CommentController@unseen')->name('unseen');
        Route::get('getNotifydata', 'CommentController@getNotifydata')->name('getNotifydata');
        Route::get('readNoty/{id}', 'CommentController@readNotification')->name('readNoty');

    });
});
/*Route::get('payment', 'Frontend\AskQuestionController@payment')->name('payment');*/
Route::post('payments_sdk', 'PaypalController@sdk')->name('payments_sdk');
Route::get('payments/success', 'PaypalController@success')->name('payments.success');
Route::get('payments/cancel', 'PaypalController@cancel')->name('payments.cancel');
Route::get('verify/{id}', 'Frontend\HomeController@verify_email')->name('verify');
Route::get('testmail', 'Frontend\HomeController@testmail')->name('test');
Route::get('mail-template', 'Frontend\HomeController@mail_template')->name('tenplate');

Route::get('create-slug/{id}', 'Frontend\AskQuestionController@createAllSlug')->name('create-slug');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear ');

    return 'Routes cache cleared';
});
