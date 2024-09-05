<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubPageOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_page_operations')->insert([
            //systems operations
            ['sub_page_id' => 1, 'operation' => 'systems'],
            ['sub_page_id' => 1, 'operation' => 'systemDetails'],
            ['sub_page_id' => 2, 'operation' => 'newSystem'],
            ['sub_page_id' => 3, 'operation' => 'updateSystem'],
            ['sub_page_id' => 4, 'operation' => 'destroySystem'],

            //customers operations
            ['sub_page_id' => 5, 'operation' => 'customers'],
            ['sub_page_id' => 5, 'operation' => 'allCustomers'],
            ['sub_page_id' => 5, 'operation' => 'showCustomer'],
            ['sub_page_id' => 5, 'operation' => 'newCustomerUser'],
            ['sub_page_id' => 5, 'operation' => 'updateCustomerUser'],
            ['sub_page_id' => 5, 'operation' => 'destroyCustomerUser'],
            ['sub_page_id' => 5, 'operation' => 'CustomerBill'],
            ['sub_page_id' => 5, 'operation' => 'printCustomers'],
            ['sub_page_id' => 6, 'operation' => 'addCustomer'],
            ['sub_page_id' => 6, 'operation' => 'storeCustomer'],
            ['sub_page_id' => 7, 'operation' => 'editCustomer'],
            ['sub_page_id' => 7, 'operation' => 'updateCustomer'],
            ['sub_page_id' => 8, 'operation' => 'destroyCustomer'],
            ['sub_page_id' => 9, 'operation' => 'customerSendMail'],
            ['sub_page_id' => 9, 'operation' => 'emailCustomer'],
            ['sub_page_id' => 9, 'operation' => 'CustomerMessages'],

            //packages
            ['sub_page_id' => 10, 'operation' => 'packages'],
            ['sub_page_id' => 10, 'operation' => 'allPackages'],
            ['sub_page_id' => 11, 'operation' => 'addPackage'],
            ['sub_page_id' => 11, 'operation' => 'storePackage'],
            ['sub_page_id' => 11, 'operation' => 'newPackage'],
            ['sub_page_id' => 12, 'operation' => 'editPackage'],
            ['sub_page_id' => 12, 'operation' => 'updatePackage'],
            ['sub_page_id' => 13, 'operation' => 'destroyPackage'],

            //mjors
            ['sub_page_id' => 14, 'operation' => 'majors'],
            ['sub_page_id' => 15, 'operation' => 'newMajor'],
            ['sub_page_id' => 16, 'operation' => 'updateMajor'],
            ['sub_page_id' => 17, 'operation' => 'destroyMajor'],

            //minors
            ['sub_page_id' => 18, 'operation' => 'minors'],
            ['sub_page_id' => 18, 'operation' => 'allMinors'],
            ['sub_page_id' => 19, 'operation' => 'newMinor'],
            ['sub_page_id' => 20, 'operation' => 'updateMinor'],
            ['sub_page_id' => 21, 'operation' => 'destroyMinor'],

            //properties
            ['sub_page_id' => 22, 'operation' => 'properties'],
            ['sub_page_id' => 22, 'operation' => 'allProperties'],
            ['sub_page_id' => 23, 'operation' => 'addProperty'],
            ['sub_page_id' => 23, 'operation' => 'newProperty'],
            ['sub_page_id' => 24, 'operation' => 'editProperty'],
            ['sub_page_id' => 24, 'operation' => 'updateProperty'],
            ['sub_page_id' => 25, 'operation' => 'destroyProperty'],

            //info
            ['sub_page_id' => 22, 'operation' => 'info'],
            ['sub_page_id' => 22, 'operation' => 'editInfo'],

            //towns
            ['sub_page_id' => 28, 'operation' => 'towns'],
            ['sub_page_id' => 29, 'operation' => 'newTown'],
            ['sub_page_id' => 30, 'operation' => 'updateTown'],
            ['sub_page_id' => 31, 'operation' => 'destroyTown'],

            //governorates
            ['sub_page_id' => 32, 'operation' => 'governorates'],
            ['sub_page_id' => 33, 'operation' => 'newGovernorate'],
            ['sub_page_id' => 34, 'operation' => 'updateGovernorate'],
            ['sub_page_id' => 35, 'operation' => 'destroyGovernorate'],

            //activities
            ['sub_page_id' => 36, 'operation' => 'activities'],
            ['sub_page_id' => 37, 'operation' => 'newActivity'],
            ['sub_page_id' => 38, 'operation' => 'updateActivity'],
            ['sub_page_id' => 39, 'operation' => 'destroyActivity'],

            //Units
            ['sub_page_id' => 40, 'operation' => 'units'],
            ['sub_page_id' => 41, 'operation' => 'newUnit'],
            ['sub_page_id' => 42, 'operation' => 'updateUnit'],
            ['sub_page_id' => 42, 'operation' => 'activateUnit'],
            ['sub_page_id' => 42, 'operation' => 'inActivateUnit'],
            ['sub_page_id' => 43, 'operation' => 'destroyUnit'],

            //user Sessions
            ['sub_page_id' => 44, 'operation' => 'userSessions'],
            ['sub_page_id' => 45, 'operation' => 'destroySession'],

            //userTypes
            ['sub_page_id' => 46, 'operation' => 'userTypes'],
            ['sub_page_id' => 47, 'operation' => 'newUserType'],
            ['sub_page_id' => 48, 'operation' => 'updateUserType'],
            ['sub_page_id' => 49, 'operation' => 'destroyUserType'],

            //users
            ['sub_page_id' => 50, 'operation' => 'users'],
            ['sub_page_id' => 50, 'operation' => 'allUsers'],
            ['sub_page_id' => 50, 'operation' => 'levels'],

            ['sub_page_id' => 51, 'operation' => 'newUser'],
            ['sub_page_id' => 51, 'operation' => 'newLevel'],
            ['sub_page_id' => 51, 'operation' => 'addLevel'],

            ['sub_page_id' => 52, 'operation' => 'updateUser'],
            ['sub_page_id' => 52, 'operation' => 'editLevel'],
            ['sub_page_id' => 52, 'operation' => 'updateLevel'],

            ['sub_page_id' => 53, 'operation' => 'destroyUser'],
            ['sub_page_id' => 53, 'operation' => 'destroyLevel'],

            //reports
            ['sub_page_id' => 54, 'operation' => 'customer_systems_report'],
            ['sub_page_id' => 54, 'operation' => 'print_customers_systems_report'],
            ['sub_page_id' => 55, 'operation' => 'customer_towns_report'],
            ['sub_page_id' => 55, 'operation' => 'print_customers_towns_report'],
            ['sub_page_id' => 56, 'operation' => 'customer_governorates_report'],
            ['sub_page_id' => 56, 'operation' => 'print_customers_governorates_report'],
            ['sub_page_id' => 57, 'operation' => 'customer_packages_report'],
            ['sub_page_id' => 57, 'operation' => 'print_customers_packages_report'],
            ['sub_page_id' => 58, 'operation' => 'customer_substraction_report'],
            ['sub_page_id' => 58, 'operation' => 'print_customer_substraction_report'],

            //others
            ['sub_page_id' => 59, 'operation' => 'changePassword'],

        ]);
    }
}
