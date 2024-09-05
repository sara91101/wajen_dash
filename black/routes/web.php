<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
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
    return view('send-mail');
});

Route::get('/', [LoginController::class,'showLoginForm'])->name('login');
Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');
Route::get('/generate_pdf', [CustomerController::class, 'generate_pdf']);
// Auth::routes();
Route::group(['middleware' => ['auth','Privilege']],function()
{
    //others
    Route::get('/changeMode', [HomeController::class, 'changeMode'])->name('changeMode');
    Route::post('/changePassword', [UserController::class, 'changePassword'])->name('changePassword');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/info', [HomeController::class, 'info'])->name('info');
    Route::post('/editInfo', [HomeController::class, 'editInfo'])->name('editInfo');

    //Towns
    Route::get('/towns', [TownController::class, 'index'])->name('towns');
    Route::post('/newTown', [TownController::class, 'store'])->name('newTown');
    Route::get('/destroyTown/{town_id}', [TownController::class, 'destroy'])->name('destroyTown');
    Route::post('/updateTown', [TownController::class, 'update'])->name('updateTown');

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
    Route::post('/services', [ServiceController::class, 'store'])->name('newService');
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

});
