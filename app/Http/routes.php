<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use App\Models\State;
use App\Models\Promo;
use App\Models\User;
use App\Models\Catalog;

use App\Functions\CardConnect;

Route::get('/course-not-found',function()
{
    return View::make('courses.not-found');
});

Route::get('/',function()
{    
    return Redirect::to('store-catalog');
});

Route::get('/welcome',function()
{
    return Redirect::to('store-catalog');
});

Route::any('catalog-search','CourseController@catalogSearch');

Route::any('catalog/{parentName}/{childName}/{childId}','CourseController@catalogSubCategory');

Route::group(['middleware' => 'App\Http\Middleware\Admin'], function() {
//ADMIN
    Route::get('admin', 'AdminController@adminHome')->middleware('auth');
    Route::get('maven', 'AdminController@adminHome')->middleware('auth');

    Route::get('admin/users', 'AdminController@showUsers')->middleware('auth');
    Route::post('admin/users/search', 'AdminController@searchUsers')->middleware('auth');

    Route::get('admin/photos/{courseid?}', 'AdminController@showPhotoForm')->middleware('auth');
    Route::post('admin/photos/upload', 'AdminController@uploadPhoto')->middleware('auth');

    Route::get('admin/catalog/update', 'AdminController@updateCatalog')->middleware('auth');
    Route::get('admin/catalog', 'AdminController@viewCatalog')->middleware('auth');

    Route::get('admin/sessions/update', 'AdminController@updateCatalog')->middleware('auth');
    Route::get('admin/sessions', 'AdminController@viewSessions')->middleware('auth');

    Route::get('admin/promos', 'AdminController@showPromos')->middleware('auth');
    Route::get('admin/promos/new', 'AdminController@showPromForm')->middleware('auth');
    Route::get('admin/promos/add', 'AdminController@addPromo')->middleware('auth');
    Route::post('admin/promos/add', 'AdminController@addPromo')->middleware('auth');
    Route::get('admin/promos/disable/{id}', 'AdminController@disablePromo')->middleware('auth');
    Route::get('admin/promos/enable/{id}', 'AdminController@enablePromo')->middleware('auth');
    Route::get('admin/promos/delete/{id}', 'AdminController@deletePromo')->middleware('auth');

    Route::get('admin/promos/remove', 'AdminController@removePromo')->middleware('auth');
    Route::post('admin/promos/search', 'AdminController@searchPromo')->middleware('auth');


    Route::get('admin/reports', 'AdminController@dataDump')->middleware('auth');
    Route::get('admin/store_purchase_order', 'AdminController@storePurchaseOrder')->middleware('auth');
    Route::post('admin/pull-report', 'AdminController@getDataDump')->middleware('auth');

    Route::get('/users/{id}/impersonate', 'SessionsController@impersonate')->middleware('auth');
    Route::get('/users/stop', 'SessionsController@stopImpersonate')->middleware('auth');

    Route::get('/users/make-admin/{id}', 'AdminController@makeAdmin')->middleware('auth');
    Route::get('/users/remove-admin/{id}', 'AdminController@removeAdmin')->middleware('auth');

    Route::match(['get', 'post'], 'admin/faqs', function () {
        return \Maven::view();
    });


    Route::group(['middleware' => 'auth'], function () {
        Route::any('admin/category/home', 'AdminController@categoryHome');
        Route::any('admin/category/view-all', 'CategoryController@showCategories');
        Route::any('admin/category/add', 'CategoryController@addCategory');
        Route::any('admin/category/edit/{id}', 'CategoryController@editCategory');
        Route::any('admin/category/delete/{id}', 'CategoryController@deleteCategory');
        Route::any('admin/category/update/{id}', 'CategoryController@updateCategory');
        Route::any('admin/category/assign-sub/{id}', 'CategoryController@assignSubCategory');

        Route::any('admin/subcategory/view-all/{id?}', 'SubCategoryController@showSubCategories');
        Route::any('admin/subcategory/add', 'SubCategoryController@addSubCategory');
        Route::any('admin/subcategory/edit/{id}', 'SubCategoryController@editSubCategory');
        Route::any('admin/subcategory/delete/{id}', 'SubCategoryController@deleteSubCategory');
        Route::any('admin/subcategory/update/{id}', 'SubCategoryController@updateSubCategory');


    });




});
//ACCOUNT

Route::get('new-account','AccountController@registrationForm');

Route::post('create-account','AccountController@createAccount');

Route::get('create-account','AccountController@createAccount');

Route::get('account-exists','AccountController@accountExists');

/* Verification from Email */
Route::get('verify-account','AccountController@verifyLMSAccount');

/* Message to check email for verification */
Route::get('email-verification','AccountController@verifyMessage');

Route::get('faqs','FAQController@getFAQs');


Route::group(['middleware' => 'impersonate'], function()
{
    /* User SSO */
    Route::get('sso','AccountController@singleSignOn')->middleware('auth');

    Route::get('account/profile','AccountController@editUser')->middleware('auth');
    // User Account
    Route::post('account/update-account','AccountController@updateAccount')->middleware('auth');

    Route::get('account/update-account','AccountController@updateAccount')->middleware('auth');

    // User Billing

    /* Show Single Invoice to User */
    Route::post('orders/invoice','BillingController@getInvoiceFile')->middleware('auth');

    /* Show All invoices to user */
    Route::get('orders/show-orders','BillingController@getAllInvoices')->middleware('auth');

    /* Show Order Details*/
    Route::get('orders/order-details/{orderid?}', 'BillingController@showOrder')->middleware('auth');

    // Activation Codes
    Route::post('account/register-vehicle','AccountController@activationCodes')->middleware('auth');

    Route::get('account/register-vehicle','AccountController@activationCodes')->middleware('auth');

    Route::post('account/new-vehicle','AccountController@newActivation')->middleware('auth');

    Route::get('account/new-vehicle','AccountController@newActivation')->middleware('auth');

    Route::post('account/new-vehicle-add','AccountController@addActivation')->middleware('auth');

    Route::get('account/new-vehicle-add','AccountController@addActivation')->middleware('auth');

    /* Assign Course Seat to Self */
    Route::post('billing/assign-to-me/{seatid?}','BillingController@assignCourseToSelf')->middleware('auth');

    Route::get('billing/assign-to-me/{seatid?}','BillingController@assignCourseToSelf')->middleware('auth');

    /* Assign Course Seat to existing */
    Route::post('billing/assign-to-existing/{seatid?}','BillingController@assignCourseToExisting')->middleware('auth');

    Route::get('billing/assign-to-existing/{seatid?}','BillingController@assignCourseToExisting')->middleware('auth');

    /* Assign Course Seat to new */
    Route::post('billing/assign-to-new/{seatid?}','BillingController@assignCourseToNew')->middleware('auth');

    Route::get('billing/assign-to-new/{seatid?}','BillingController@assignCourseToNew')->middleware('auth');

    /* Assign Course Seat to form */
    Route::post('billing/assign-to-form/{seatid?}','BillingController@showAssignForm')->middleware('auth');

    Route::get('billing/assign-to-form/{seatid?}','BillingController@showAssignForm')->middleware('auth');
});


//Cart

/* Remove course from cart */
Route::post('remove-course','CartController@removeFromCart');
Route::get('remove-course','CartController@removeFromCart');

/* Update course qty */
Route::post('update-cart','CartController@updateCart');
Route::get('update-cart','CartController@updateCart');

/* Add course to cart */
Route::any('add-to-cart','CartController@addToCart');

/* show course from cart */
Route::get('show-cart',array('as' => 'show.cart','uses' => 'CartController@showCart'));

/* add discount */
Route::get('add-discount','PromoController@addDiscount')->middleware('auth');
Route::post('add-discount','PromoController@addDiscount')->middleware('auth');

/* remove discount */
Route::get('remove-discount','PromoController@removeDiscount')->middleware('auth');
Route::post('remove-discount','PromoController@removeDiscount')->middleware('auth');

Route::get('check-email','AccountController@findUser')->middleware('auth');
Route::post('check-email','AccountController@findUser')->middleware('auth');


/* assign existing user to
//Checkout

/* Step One Show Courses To Assign */
Route::post('checkout-step-1','CheckoutController@stepOne')->middleware('auth');
Route::get('checkout-step-1','CheckoutController@stepOne')->middleware('auth');

/* Step Two Show Billing Form */
Route::post('checkout-step-2','CheckoutController@stepTwo')->middleware('auth');
Route::get('checkout-step-2','CheckoutController@stepTwo')->middleware('auth');

/* Free Checkout */
Route::post('checkout-free','CheckoutController@stepFree')->middleware('auth');
Route::get('checkout-free','CheckoutController@stepFree')->middleware('auth');

/* Assign User to Self or Show Form for Other */
Route::get('assign-course','CartController@assignCourse');
Route::post('assign-course','CartController@assignCourse');

/* Assign User to Other */
Route::get('assign-course-other','CartController@assignExistingUserToCourse');
Route::post('assign-course-other','CartController@assignExistingUserToCourse');

/* Assign User to New */
Route::get('assign-course-new','CartController@assignNewUserToCourse');
Route::post('assign-course-new','CartController@assignNewUserToCourse');

/* Assign Empty Users */
Route::get('show-seat/{seatid?}','BillingController@showAssignSeat')->middleware('auth');
Route::post('show-seat/{seatid?}','BillingController@showAssignSeat')->middleware('auth');

/* show course from cart */
Route::post('checkout','CheckoutController@checkoutCart')->middleware('auth');
Route::get('checkout','CheckoutController@checkoutCart')->middleware('auth');

/* process checkout (charge card and create user in LMS) */
Route::post('preview-checkout','CheckoutController@checkoutPreview')->middleware('auth');

/* process checkout (charge card and create user in LMS) */
Route::get('preview-checkout','CheckoutController@checkoutPreview')->middleware('auth');

/* process checkout (charge card and create user in LMS) */
Route::post('complete-checkout','CheckoutController@checkoutComplete')->middleware('auth');

/* process checkout (charge card and create user in LMS) */
Route::get('complete-checkout','CheckoutController@checkoutComplete')->middleware('auth');

/* checkout success and send to thank you */
Route::get('thank-you',array('as' => 'payment.thankyou','uses' => 'CheckoutController@thankYou'))->middleware('auth');

//COURSE

/* Confirm course to cart */
Route::get('confirm-course','CourseController@confirmCourses');

Route::post('confirm-course','CourseController@confirmCourses');

Route::get('store-catalog','CourseController@getCourses');

//SESSION

// User Logout
Route::get('logout','SessionsController@destroy');

// Resourceful Route for Sessions
Route::resource('sessions','SessionsController');


//Existing LMS User

Route::get('/lms/find-user','AccountController@findLMSAccount');
Route::get('/lms/verify-user','AccountController@findVerifyLMSAccount');
Route::get('/lms/create-account','AccountController@createLMSAccount');
Route::post('/lms/create-account','AccountController@createLMSAccount');




Route::get('sso-lms', function(){

    //$input = Request::get('lmsid');

    //return $input;

    if (Auth::check())
    {
        return Redirect::to('welcome');
    }

    if(Request::get('lmsid')){

        $input = Request::get('lmsid');

        $input= str_replace('/admin/people/','',$input);
        $input= str_replace('/avatar','',$input);

        //check if we have the id in the local db
        $userInfo = User::where('litmos_original_id',$input)->first();

        //return $userInfo;

        //if we do, send them into store
        if(count($userInfo)) {
            Auth::login($userInfo);

            if ($userInfo['active'] == 0){
                User::updateExistingLMSLogin($userInfo);
            }

            return Redirect::to('welcome');
        }else{
            return Redirect::action('AccountController@findLMSAccount', array('username'=>Request::get('lmsuser')));
        }
    }else{

        return Redirect::to('/');
    }



});


//MISC

/* Queue Marshal */
route::post('queue/ps-ecomm-demo',function()
{
    return Queue::marshal();
});


Route::auth();

//Route::get('/home', 'HomeController@index');

Route::get('/home',function()
{    
    return Redirect::to('store-catalog');
});




//New Register Routes
Route::any('/team/register','TeamRegisterController@showForm');
Route::any('/team/register/create','TeamRegisterController@createAccount');
Route::any('/team/register/thank-you','TeamRegisterController@thankYou');







Route::group(['middleware' => 'auth'], function () {
    Route::get('checkout', 'PaymentController@checkout');

    Route::get('payment_type', 'CheckoutController@paymentOptions');

    Route::post('select_payment_option', 'CheckoutController@selectPaymentOption');

    Route::get('pay-by-cheque', 'CheckoutController@payByCheque');

    Route::post('create_cheque_payment', 'CheckoutController@createChequePayment');

    Route::get('/downloadPDF/{id}','CheckoutController@downloadPDF');

    Route::get('paypal_access_token', 'PaymentController@getAccessToken');

    Route::get('paypal_payment/{token}', 'PaymentController@pay_amount');

    Route::resource('orders', 'OrderController');

    Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));

    Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));

    Route::get('paypal', array('as' => 'payment.status','uses' => 'CheckoutController@getPaymentStatus',));

    // Buy One Get One Feature
    Route::resource('bogo', 'BogoController');

    Route::resource('settings', 'SettingController');

});

Route::get('categories', function(){
    $id = \Illuminate\Support\Facades\Input::get('option');
    $result = \App\Models\Category::where('parent_id', $id)->lists('name','id');
    return $result;
});


Route::get('course_sessions/sync/', 'CourseSessionController@sync');
Route::get('iltsessions/{search?}/{sort?}', 'CourseSessionController@index');
Route::resource('course_sessions', 'CourseSessionController');

// User Account
Route::get('account/profile/{email}','AccountController@completeProfile');
Route::post('account/update_profile','AccountController@updateProfile');


Route::controller('password', 'RemindersController');