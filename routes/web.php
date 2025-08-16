<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogDepartmentController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerUserTypeController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GovernorateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MinorController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SystmController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\LoyaltyConditionController;
use App\Http\Controllers\LoyaltyContactController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\LoyaltyCustomerController;
use App\Http\Controllers\LoyaltyFAQController;
use App\Http\Controllers\LoyaltySliderController;
use App\Http\Controllers\LoyaltySplashController;
use App\Http\Controllers\PrivacyFirstController;
use App\Http\Controllers\PriceShowController;
use App\Http\Controllers\SkilltaxReports;
use App\Http\Controllers\CasheirServiceController;
use App\Http\Controllers\FreeTrialOtpController;
use App\Http\Controllers\SubscriberCustomerNotificationController;
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

Route::get('/design', function () {
    $data["name"] = "sarah abbas";
    $data["membership_no"] = "70088";
    $data["subscription_start_at"] = "july 2025";
    $data["subscription_end_at"] = "july 2028";
    return view('send-mail',$data);
});

Route::get('/', [LoginController::class,'showLoginForm'])->name('login');
Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');
Route::get('/generate_pdf', [CustomerController::class, 'generate_pdf']);

Route::group(['middleware' => 'auth'],function()
{
    Route::get('/sendOtpMessage', [LoginController::class, 'sendOtpMessage'])->name('sendOtpMessage');
    Route::post('/checkVerificationCode', [LoginController::class, 'checkVerificationCode'])->name('checkVerificationCode');
});
// Auth::routes();
Route::group(['middleware' => ['auth','Privilege','verified']],function()
{
    //others
    Route::get('/changeMode', [HomeController::class, 'changeMode'])->name('changeMode');
    Route::post('/changePassword', [UserController::class, 'changePassword'])->name('changePassword');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home', [HomeController::class, 'index'])->name('home');


    Route::get('/info', [HomeController::class, 'info'])->name('info');
    Route::post('/editInfo', [HomeController::class, 'editInfo'])->name('editInfo');

    //Towns
    Route::get('/towns', [TownController::class, 'index'])->name('towns');
    Route::post('/newTown', [TownController::class, 'store'])->name('newTown');
    Route::get('/destroyTown/{town_id}', [TownController::class, 'destroy'])->name('destroyTown');
    Route::post('/updateTown', [TownController::class, 'update'])->name('updateTown');

    //casheir services
    Route::get('/casheirServices', [CasheirServiceController::class, 'index'])->name('casheirServices');
    Route::post('/newService', [CasheirServiceController::class, 'store'])->name('newService');
    Route::get('/destroycasheirService/{Service_id}', [CasheirServiceController::class, 'destroy'])->name('destroycasheirService');
    Route::post('/updatecasheirService', [CasheirServiceController::class, 'update'])->name('updatecasheirService');

    //governorates
    Route::get('/governorates', [GovernorateController::class, 'index'])->name('governorates');
    Route::post('/newGovernorate', [GovernorateController::class, 'store'])->name('newGovernorate');
    Route::get('/destroyGovernorate/{Governorate_id}', [GovernorateController::class, 'destroy'])->name('destroyGovernorate');
    Route::post('/updateGovernorate', [GovernorateController::class, 'update'])->name('updateGovernorate');

    //systems
    Route::get('/systems', [SystmController::class, 'index'])->name('systems');
    Route::post('/newSystem', [SystmController::class, 'store'])->name('newSystem');
    Route::post('/updateSystem', [SystmController::class, 'update'])->name('updateSystem');
    Route::get('/destroySystem/{system_id}', [SystmController::class, 'destroy'])->name('destroySystem');
    Route::get('/systemDetails/{system_id}', [SystmController::class, 'show'])->name('systemDetails');

    //majors
    Route::get('/majors', [MajorController::class, 'index'])->name('majors');
    Route::post('/newMajor', [MajorController::class, 'store'])->name('newMajor');
    Route::post('/updateMajor', [MajorController::class, 'update'])->name('updateMajor');
    Route::get('/destroyMajor/{Major_id}', [MajorController::class, 'destroy'])->name('destroyMajor');

    //minors
    Route::get('/minors', [MinorController::class, 'index'])->name('minors');
    Route::post('/minors', [MinorController::class, 'index'])->name('minors');
    Route::get('/allMinors', [MinorController::class, 'showAll'])->name('allMinors');
    Route::post('/newMinor', [MinorController::class, 'store'])->name('newMinor');
    Route::post('/updateMinor', [MinorController::class, 'update'])->name('updateMinor');
    Route::get('/destroyMinor/{Minor_id}', [MinorController::class, 'destroy'])->name('destroyMinor');

    //properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::post('/properties', [PropertyController::class, 'index'])->name('properties');
    Route::get('/allProperties', [PropertyController::class, 'showAll'])->name('allProperties');
    Route::post('/addProperty', [PropertyController::class, 'create'])->name('addProperty');
    Route::post('/newProperty', [PropertyController::class, 'store'])->name('newProperty');
    Route::get('/editProperty/{Property_id}', [PropertyController::class, 'edit'])->name('editProperty');
    Route::post('/updateProperty/{Property_id}', [PropertyController::class, 'update'])->name('updateProperty');
    Route::get('/destroyProperty/{Property_id}', [PropertyController::class, 'destroy'])->name('destroyProperty');

    //packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::post('/packages', [PackageController::class, 'index'])->name('packages');
    Route::get('/allPackages', [PackageController::class, 'showAll'])->name('allPackages');
    Route::get('/addPackage', [PackageController::class, 'create'])->name('addPackage');
    Route::post('/storePackage', [PackageController::class, 'store'])->name('storePackage');
    Route::post('/newPackage', [PackageController::class, 'store'])->name('newPackage');
    Route::get('/editPackage/{Package_id}', [PackageController::class, 'edit'])->name('editPackage');
    Route::post('/updatePackage/{Package_id}', [PackageController::class, 'update'])->name('updatePackage');
    Route::get('/destroyPackage/{Package_id}', [PackageController::class, 'destroy'])->name('destroyPackage');

    //activities
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities');
    Route::post('/newActivity', [ActivityController::class, 'store'])->name('newActivity');
    Route::post('/updateActivity', [ActivityController::class, 'update'])->name('updateActivity');
    Route::get('/destroyActivity/{Activity_id}', [ActivityController::class, 'destroy'])->name('destroyActivity');

    //userTypes
    Route::get('/userTypes', [CustomerUserTypeController::class, 'index'])->name('userTypes');
    Route::post('/userTypes', [CustomerUserTypeController::class, 'index'])->name('userTypes');
    Route::post('/newUserType', [CustomerUserTypeController::class, 'store'])->name('newUserType');
    Route::post('/updateUserType', [CustomerUserTypeController::class, 'update'])->name('updateUserType');
    Route::get('/destroyUserType/{UserTypes_id}', [CustomerUserTypeController::class, 'destroy'])->name('destroyUserType');

    //Units
    Route::get('/units', [UnitController::class, 'index'])->name('units');
    Route::post('/newUnit', [UnitController::class, 'store'])->name('newUnit');
    Route::get('/destroyUnit/{Unit_id}', [UnitController::class, 'destroy'])->name('destroyUnit');
    Route::get('/activateUnit/{Unit_id}', [UnitController::class, 'activateUnit'])->name('activateUnit');
    Route::get('/inActivateUnit/{Unit_id}', [UnitController::class, 'inActivateUnit'])->name('inActivateUnit');
    Route::post('/updateUnit', [UnitController::class, 'update'])->name('updateUnit');

    //casheirs
    Route::get('/casheirs', [CustomerController::class, 'casheirs'])->name('casheirs');
    Route::post('/casheirs', [CustomerController::class, 'casheirs'])->name('casheirs');
    Route::get('/archiveCustomers', [CustomerController::class, 'archiveCustomers'])->name('archiveCustomers');
    Route::post('/archiveCustomers', [CustomerController::class, 'archiveCustomers'])->name('archiveCustomers');
    Route::get('/casheirActivate/{customer_id}/{first_name}/{last_name}/{staff_no}/{email}/{casheir}/{status}', [CustomerController::class, 'casheirActivate'])->name('casheirActivate');
    Route::get('/unArchiveCustomer/{customer_id}', [CustomerController::class, 'unArchiveCustomer'])->name('unArchiveCustomer');

    //customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/allCustomers', [CustomerController::class, 'showAll'])->name('allCustomers');
    Route::get('/addCustomer', [CustomerController::class, 'create'])->name('addCustomer');
    Route::post('/storeCustomer', [CustomerController::class, 'store'])->name('storeCustomer');
    Route::get('/showCustomer/{Customer_id}', [CustomerController::class, 'show'])->name('showCustomer');
    Route::get('/emailCustomer/{Customer_id}', [CustomerController::class, 'emailCustomer'])->name('emailCustomer');
    Route::get('/editCustomer/{Customer_id}', [CustomerController::class, 'edit'])->name('editCustomer');
    Route::post('/updateCustomer/{Customer_id}', [CustomerController::class, 'update'])->name('updateCustomer');
    Route::get('/destroyCustomer/{Customer_id}', [CustomerController::class, 'destroy'])->name('destroyCustomer');
    Route::post('/newCustomerUser/{Customer_id}', [CustomerController::class, 'newCustomerUser'])->name('newCustomerUser');
    Route::post('/updateCustomerUser', [CustomerController::class, 'updateCustomerUser'])->name('updateCustomerUser');
    Route::get('/destroyCustomerUser/{user_id}', [CustomerController::class, 'destroyCustomerUser'])->name('destroyCustomerUser');
    Route::get('/CustomerBill/{customer_id}/{package_id}/{status}', [CustomerController::class, 'CustomerBill'])->name('CustomerBill');
    Route::get('/CustomerMessages/{customer_id}/{membership_no}', [CustomerController::class, 'CustomerMessages'])->name('CustomerMessages');
    Route::get('/printCustomers', [CustomerController::class, 'printCustomers'])->name('printCustomers');
    Route::post('/customerSendMail', [CustomerController::class, 'customerSendMail'])->name('customerSendMail');
    Route::get('/destroyBranch/{branch_id}/{customer_id}', [CustomerController::class, 'archieveBranch'])->name('destroyBranch');
    Route::post('/sendInvoice', [CustomerController::class, 'sendInvoice'])->name('sendInvoice');
    Route::get('/sendSubscriptionDetails/{customer_id}', [CustomerController::class, 'sendSubscriptionDetails'])->name('sendSubscriptionDetails');
    
    Route::get('/destroyCustomerDevice/{device_id}', [CustomerController::class, 'destroyCustomerDevice'])->name('destroyCustomerDevice');
    Route::post('/editDevice', [CustomerController::class, 'editDevice'])->name('editDevice');

    Route::get('/inActivateCustomer/{customer_id}', [CustomerController::class, 'inActivateCustomer'])->name('inActivateCustomer');
    Route::get('/customerActivate/{customer_id}', [CustomerController::class, 'customerActivate'])->name('customerActivate');

    //reports
    Route::get('/customer_systems_report', [ReportController::class, 'customers_systems_report'])->name('customer_systems_report');
    Route::get('/print_customers_systems_report', [ReportController::class, 'print_customers_systems_report'])->name('print_customers_systems_report');

    Route::get('/customer_towns_report', [ReportController::class, 'customers_towns_report'])->name('customer_towns_report');
    Route::get('/print_customers_towns_report', [ReportController::class, 'print_customers_towns_report'])->name('print_customers_towns_report');

    Route::get('/customer_governorates_report', [ReportController::class, 'customers_governorates_report'])->name('customer_governorates_report');
    Route::get('/print_customers_governorates_report', [ReportController::class, 'print_customers_governorates_report'])->name('print_customers_governorates_report');

    Route::get('/customer_packages_report', [ReportController::class, 'customers_packages_report'])->name('customer_packages_report');
    Route::get('/print_customers_packages_report', [ReportController::class, 'print_customers_packages_report'])->name('print_customers_packages_report');

    Route::get('/customer_substraction_report', [ReportController::class, 'customer_substraction_report'])->name('customer_substraction_report');
    Route::get('/print_customer_substraction_report', [ReportController::class, 'print_customer_substraction_report'])->name('print_customer_substraction_report');

    //user Sessions
    Route::get('/userSessions', [UserSessionController::class, 'index'])->name('userSessions');
    Route::post('/userSessions', [UserSessionController::class, 'index'])->name('userSessions');
    Route::get('/destroySession/{Session_id}', [UserSessionController::class, 'destroy'])->name('destroySession');

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users', [UserController::class, 'index'])->name('users');
    Route::get('/allUsers', [UserController::class, 'showAll'])->name('allUsers');
    Route::post('/newUser', [UserController::class, 'store'])->name('newUser');
    Route::post('/updateUser', [UserController::class, 'update'])->name('updateUser');
    Route::get('/destroyUser/{User_id}', [UserController::class, 'destroy'])->name('destroyUser');

    //levels
    Route::get('/levels', [LevelController::class, 'index'])->name('levels');
    Route::get('/addLevel', [LevelController::class, 'create'])->name('addLevel');
    Route::post('/newLevel', [LevelController::class, 'store'])->name('newLevel');
    Route::get('/editLevel/{level_id}', [LevelController::class, 'edit'])->name('editLevel');
    Route::post('/updateLevel/{level_id}', [LevelController::class, 'update'])->name('updateLevel');
    Route::get('/destroyLevel/{Level_id}', [LevelController::class, 'destroy'])->name('destroyLevel');

    //services
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/services', [ServiceController::class, 'store'])->name('newServices');
    Route::post('/updateService', [ServiceController::class, 'update'])->name('updateService');
    Route::get('/destroyService/{Service_id}', [ServiceController::class, 'destroy'])->name('destroyService');

    //questions
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
    Route::get('/destroyQuestion/{Question_id}', [QuestionController::class, 'destroy'])->name('destroyQuestion');
    Route::get('/answerQuestion/{Question_id}', [QuestionController::class, 'answer'])->name('answerQuestion');
    Route::get('/detailQuestion/{Question_id}', [QuestionController::class, 'show'])->name('detailQuestion');
    Route::post('/reply', [QuestionController::class, 'reply'])->name('reply');

    //faqs
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');
    Route::post('/faqs', [FaqController::class, 'store'])->name('newFaq');
    Route::post('/updateFaq', [FaqController::class, 'update'])->name('updateFaq');
    Route::get('/faqs/{Faq_id}', [FaqController::class, 'destroy'])->name('destroyFaq');

    //demands
    Route::get('/demands', [DemandController::class, 'index'])->name('demands');
    Route::get('/destroyDemand/{Demand_id}', [DemandController::class, 'destroy'])->name('destroyDemand');
    Route::get('/registerDemand/{Demand_id}', [DemandController::class, 'registerDemand'])->name('registerDemand');

   //privacy
    Route::get('/privacy', [PrivacyFirstController::class, 'show'])->name('privacy');
    Route::get('/addPrivacy', [PrivacyFirstController::class, 'create'])->name('addPrivacy');
    Route::get('/editPrivacy/{Privacy_id}', [PrivacyFirstController::class, 'edit'])->name('editPrivacy');
    Route::post('/newPrivacy', [PrivacyFirstController::class, 'store'])->name('newPrivacy');
    Route::get('/destroyPrivacy/{Privacy_id}', [PrivacyFirstController::class, 'destroy'])->name('destroyPrivacy');
    Route::post('/updatePrivacy/{Privacy_id}', [PrivacyFirstController::class, 'update'])->name('updatePrivacy');


//price show
    Route::get('/priceShow', [PriceShowController::class, 'index'])->name("priceShow");
    Route::get('/priceShow/{priceShow_id}', [PriceShowController::class, 'show'])->name("priceShow");
    Route::get('/editPriceShow/{priceShow_id}', [PriceShowController::class, 'edit'])->name("editPriceShow");
    Route::get('/createPriceShow', [PriceShowController::class, 'create'])->name("createPriceShow");
    Route::post('/priceShow', [PriceShowController::class, 'store'])->name("storePriceShow");
    Route::post('/priceShow/{priceShow_id}', [PriceShowController::class, 'update'])->name("UpdatePriceShow");
    Route::get('/destroyPriceShow/{priceShow_id}', [PriceShowController::class, 'destroy'])->name("destroyPriceShow");


    //inquireis
    Route::get('/inquiries', [InquiryController::class, 'index'])->name("inquiries");
    Route::get('/inquiries/{id}', [InquiryController::class, 'show'])->name("inquiries");
    Route::post('/inquiryAnswer/{id}', [InquiryController::class, 'reply'])->name("inquiryAnswer");
    Route::get('/destroyInquiry/{id}', [InquiryController::class, 'destroy'])->name("destroyInquiry");


    //distributors
    Route::get('/distributors', [DistributorController::class, 'index'])->name("distributors");
    Route::get('/destroyDistributor/{id}', [DistributorController::class, 'destroy'])->name("destroyDistributor");

    //friends
    Route::get('/friends', [FriendController::class, 'index'])->name("friends");
    Route::get('/destroyFriend/{id}', [FriendController::class, 'destroy'])->name("destroyFriend");


    //loyalty
    Route::get('/loyaltyAbout', [LoyaltyController::class, 'about'])->name("loyaltyAbout");
    Route::get('/editLoyaltyAbout', [LoyaltyController::class, 'edit'])->name("editLoyaltyAbout");
    Route::post('/loyaltyAbout', [LoyaltyController::class, 'updateAbout'])->name("loyaltyAbout");

    //Loyalty Slider
    Route::get('/loyaltySlider', [LoyaltySliderController::class, 'index'])->name("loyaltySlider");
    Route::post('/loyaltySlider', [LoyaltySliderController::class, 'store'])->name("addLoyaltySlider");
    Route::post('/editLoyaltySlider', [LoyaltySliderController::class, 'update'])->name("updateLoyaltySlider");
    Route::get('/loyaltySlider/{SliderId}', [LoyaltySliderController::class, 'destroy'])->name("destroyLoyaltySlider");

    //Loyalty Splash
    Route::get('/loyaltySplash', [LoyaltySplashController::class, 'index'])->name("loyaltySplash");
    Route::post('/loyaltySplash', [LoyaltySplashController::class, 'store'])->name("addLoyaltySplash");
    Route::post('/editLoyaltySplash', [LoyaltySplashController::class, 'update'])->name("updateLoyaltySplash");
    Route::get('/loyaltySplash/{SplashId}', [LoyaltySplashController::class, 'destroy'])->name("destroyLoyaltySplash");

    //Loyalty Contact
    Route::get('/loyaltyContacts', [LoyaltyContactController::class, 'index'])->name('loyaltyContacts');
    Route::get('/destroyLoyaltyContacts/{LoyaltyContacts_id}', [LoyaltyContactController::class, 'destroy'])->name('destroyLoyaltyContacts');
    Route::get('/answerLoyaltyContacts/{LoyaltyContacts_id}', [LoyaltyContactController::class, 'answer'])->name('answerLoyaltyContacts');
    Route::get('/detailLoyaltyContacts/{LoyaltyContacts_id}', [LoyaltyContactController::class, 'show'])->name('detailLoyaltyContacts');
    Route::post('/reply', [LoyaltyContactController::class, 'reply'])->name('reply');

    //Loyalty FAQ
    Route::get('/loyaltyFAQ', [LoyaltyFAQController::class, 'index'])->name("loyaltyFAQ");
    Route::post('/loyaltyFAQ', [LoyaltyFAQController::class, 'store'])->name("addLoyaltyFAQ");
    Route::post('/editLoyaltyFAQ', [LoyaltyFAQController::class, 'update'])->name("updateLoyaltyFAQ");
    Route::get('/loyaltyFAQ/{FAQId}', [LoyaltyFAQController::class, 'destroy'])->name("destroyLoyaltyFAQ");

    //Loyalty Condition
    Route::get('/loyaltyConditions', [LoyaltyConditionController::class, 'index'])->name("loyaltyCondition");
    Route::get('/addLoyaltyCondition', [LoyaltyConditionController::class, 'create'])->name("addLoyaltyCondition");
    Route::get('/editLoyaltyCondition/{conditionId}', [LoyaltyConditionController::class, 'edit'])->name("editLoyaltyCondition");
    Route::post('/loyaltyCondition', [LoyaltyConditionController::class, 'store'])->name("storeLoyaltyCondition");
    Route::post('/updateLoyaltyCondition/{conditionId}', [LoyaltyConditionController::class, 'update'])->name("updateLoyaltyCondition");
    Route::get('/destroyLoyaltyCondition/{ConditionId}', [LoyaltyConditionController::class, 'destroy'])->name("destroyLoyaltyCondition");



    Route::post('/notifyCustomer', [CustomerController::class, 'notifyCustomer'])->name("notifyCustomer");

    //blog Departments
    Route::get('/blogDepartments', [BlogDepartmentController::class, 'index'])->name("blogDepartments");
    Route::post('/blogDepartments', [BlogDepartmentController::class, 'store'])->name("blogDepartments");
    Route::post('/updateBlogDepartment', [BlogDepartmentController::class, 'update'])->name("updateBlogDepartment");
    Route::get('/destroyBlogDepartment/{id}', [BlogDepartmentController::class, 'destroy'])->name("destroyBlogDepartment");

    //blogs
    Route::get('/blogs', [BlogsController::class, 'index'])->name("blogs");
    Route::get('/createBlog', [BlogsController::class, 'create'])->name("createBlog");
    Route::post('/storeBlog', [BlogsController::class, 'store'])->name("storeBlog");
    Route::get('/editBlog/{blog_id}', [BlogsController::class, 'edit'])->name("editBlog");
    Route::get('/blog/{blog_id}', [BlogsController::class, 'blog'])->name("blog");
    Route::post('/updateBlog/{blog_id}', [BlogsController::class, 'update'])->name("updateBlog");
    Route::get('/destroyBlog/{id}', [BlogsController::class, 'destroy'])->name("destroyBlog");
    Route::get('/starBlog/{id}/{star}', [BlogsController::class, 'star'])->name("starBlog");

    //Loyalty Customers
    Route::get('/loyaltyCustomers/{page}', [LoyaltyCustomerController::class, 'index'])->name("loyaltyCustomers");
    Route::get('/notifyMultipleLoyalty', [LoyaltyCustomerController::class, 'notifyMultipleLoyalty'])->name("notifyMultipleLoyalty");
    Route::get('/messageMultipleLoyalty', [LoyaltyCustomerController::class, 'messageMultipleLoyalty'])->name("messageMultipleLoyalty");
    Route::post('/loyaltyCustomers/{page}', [LoyaltyCustomerController::class, 'index'])->name("loyaltyCustomers");
    Route::post('/sendLoyaltyNotification', [LoyaltyCustomerController::class, 'sendLoyaltyNotification'])->name("sendLoyaltyNotification");
    Route::post('/sendLoyaltyMessage', [LoyaltyCustomerController::class, 'sendLoyaltyMessage'])->name("sendLoyaltyMessage");

    Route::get('/visit/{membership_no}', [CustomerController::class, 'visit'])->name("visit");

    Route::get('/notifyMultiple', [CustomerController::class, 'notifyMultiple'])->name("notifyMultiple");

    Route::post('/sendNotification', [CustomerController::class, 'sendNotification'])->name("sendNotification");

    //keywords
    Route::get('/keywords', [KeywordController::class, 'index'])->name('keywords');
    Route::post('/newKeyword', [KeywordController::class, 'store'])->name('newKeyword');
    Route::post('/updateKeyword', [KeywordController::class, 'update'])->name('updateKeyword');
    Route::get('/destroyKeyword/{Keyword_id}', [KeywordController::class, 'destroy'])->name('destroyKeyword');

    //keys
    Route::get('/keys', [KeyController::class, 'index'])->name('keys');
    Route::post('/newKey', [KeyController::class, 'store'])->name('newKey');
    Route::post('/updateKey', [KeyController::class, 'update'])->name('updateKey');
    Route::get('/destroyKey/{Key_id}', [KeyController::class, 'destroy'])->name('destroyKey');

    //new reports
    Route::get('/paymentTransactions', [SkilltaxReports::class, 'paymentTransactions'])->name('paymentTransactions');
    Route::get('/removeSearch', [SkilltaxReports::class, 'removeSearch'])->name('removeSearch');
    Route::get('/paymentTransactionsPdf', [SkilltaxReports::class, 'paymentTransactionsPdf'])->name('paymentTransactionsPdf');
    Route::get('/paymentTransactionsExcel', [SkilltaxReports::class, 'paymentTransactionsExcel'])->name('paymentTransactionsExcel');

    Route::get('/loyaltyStatus/{membership_no}/{status}', [CustomerController::class, 'loyaltyStatus'])->name('loyaltyStatus');
    Route::get('/screenPaymentStatus/{membership_no}/{status}', [CustomerController::class, 'screenPaymentStatus'])->name('screenPaymentStatus');
    Route::get('/insuranceStatus/{membership_no}/{status}', [CustomerController::class, 'insuranceStatus'])->name('insuranceStatus');
    Route::get('/zacatStatus/{membership_no}/{status}', [CustomerController::class, 'zacatStatus'])->name('zacatStatus');

    Route::get('/skilltaxLoginReport', [SkilltaxReports::class, 'skilltaxLoginReport'])->name('skilltaxLoginReport');
    Route::get('/free_trial_repot', [FreeTrialOtpController::class, 'free_trial_repot'])->name('free_trial_repot');

    // SubscriberCustomerNotification
    Route::get('/SubscriberCustomerNotification', [SubscriberCustomerNotificationController::class, 'index']);
    Route::get('/SubscriberCustomerNotification/changeStatus/{id}/{status}', [SubscriberCustomerNotificationController::class, 'changeStatus']);


});
