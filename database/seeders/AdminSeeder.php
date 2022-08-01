<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\usersettings;
use App\Models\Customer;
use App\Models\CustomerSetting;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        

        // create permissions
		$this->createPermissions();

		// create roles
		$this->createRoles();

		// assign roles and permissions
		$this->assignPermissions();
		
        // $user = User::create(['firstname' => 'Admin',
        //     'lastname' => '1',
        //     'email' => 'admin@admin.com',
        //     'verified' => '1',
        //     'status' => '1',
        //     'image' => null,
        //     'password' =>Hash::make('admin1234'),
        //     'country' => '',
        //     'timezone' => 'UTC',
        //     'remember_token' => '',
        // ]);
        // $users = User::find($user->id);
        // $users->name = $user->firstname.' '.$user->lastname;
        // $users->update();

        // $usersetting = new usersettings();
        // $usersetting->users_id = $users->id;
        // $usersetting->save();

    // $userss = User::create(
    //     [   'firstname' => 'Agent',
    //         'lastname' => 'Agent',
    //         'email' => 'agent@agent.com',
    //         'verified' => '1',
    //         'status' => '1',
    //         'image' => null,
    //         'password' =>Hash::make('agent1234'),
    //         'country' => '',
    //         'timezone' => 'UTC',
    //         'remember_token' => '',
    //     ]
    // );
    //     $usersss = User::find($userss->id);
    //     $usersss->name = $userss->firstname.' '.$userss->lastname;
    //     $usersss->update();

    //     $usersetting = new usersettings();
    //     $usersetting->users_id = $usersss->id;
    //     $usersetting->save();

        

    //     $customer = Customer::create(['firstname' => '',
    //         'lastname' => '',
    //         'username' => 'Customer',
    //         'email' => 'customer@gmail.com',
    //         'gender' => 'Male',
    //         'verified' => '1',
    //         'status' => '1',
    //         'image' => null,
    //         'password' =>Hash::make('customer1234'),
    //         'country' => '',
    //         'userType' => 'Customer',
    //         'timezone' => 'UTC',
    //         'remember_token' => '',
    //     ]);
    //     $customersetting = new CustomerSetting();
    //     $customersetting->custs_id = $customer->id;
    //     $customersetting->save();

    //     $this->assignRoles();
		
		
    }

    public function createPermissions(){

        //Edit Profile
        Permission::create(['name' => 'Profile Edit'  , 'guard_name' => 'web',]);
        //Ticket Permission
        Permission::create(['name' => 'Ticket Access', 'guard_name' => 'web',]);
        Permission::create(['name' => 'Ticket Create' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Ticket Edit' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Ticket Delete'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Ticket Assign'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'All Tickets', 'guard_name' => 'web',]);
        Permission::create(['name' => 'My Tickets', 'guard_name' => 'web',]);
        Permission::create(['name' => 'Active Tickets' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Closed Tickets' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Assigned Tickets'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'My Assigned Tickets'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Onhold Tickets' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Overdue Tickets'  , 'guard_name' => 'web',]);
        //project premission
        Permission::create(['name' => 'Project Access', 'guard_name' => 'web',]);
        Permission::create(['name' => 'Project Create' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Project Edit' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Project Delete'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Project Assign'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Project Importlist'  , 'guard_name' => 'web',]);
        //Knowoldge permision
        Permission::create(['name' => 'Knowledge Access', 'guard_name' => 'web',]);
        //Article permision
        Permission::create(['name' => 'Article Access', 'guard_name' => 'web',]);
        Permission::create(['name' => 'Article Create' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Article View' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Article Edit' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Article Delete'  , 'guard_name' => 'web',]);
        // Category Permission
        Permission::create(['name' => 'Category Access', 'guard_name' => 'web',]);
        Permission::create(['name' => 'Category Create' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Category Edit' , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Category Assign To Groups' , 'guard_name' => 'web',]);
        //Manage Roles
        Permission::create(['name' => 'Managerole Access'  , 'guard_name' => 'web',]);
        //Roles & Permission
        Permission::create(['name' => 'Roles & Permission Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Roles & Permission Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Roles & Permission Edit'  , 'guard_name' => 'web',]);
        //Employee permision
        Permission::create(['name' => 'Employee Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Employee Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Employee Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Employee Delete'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Employee Importlist'  , 'guard_name' => 'web',]);
        //Landing Page permision
        Permission::create(['name' => 'Landing Page Access'  , 'guard_name' => 'web',]);
        //Banner Access
        Permission::create(['name' => 'Banner Access'  , 'guard_name' => 'web',]);
        //Feature Box
        Permission::create(['name' => 'Feature Box Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Feature Box Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Feature Box Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Feature Box Delete'  , 'guard_name' => 'web',]);
        //Call To Action
        Permission::create(['name' => 'Call To Action Access'  , 'guard_name' => 'web',]);
        //Testimonial Permission
        Permission::create(['name' => 'Testimonial Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Testimonial Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Testimonial Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Testimonial Delete'  , 'guard_name' => 'web',]);
        //FAQs Permission
        Permission::create(['name' => 'FAQs Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'FAQs Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'FAQs Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'FAQs Delete'  , 'guard_name' => 'web',]);
        //Customers Permission
        Permission::create(['name' => 'Customers Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Customers Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Customers Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Customers Delete'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Customers Importlist'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Customers Login'  , 'guard_name' => 'web',]);
        //Groups Permission
        Permission::create(['name' => 'Groups Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Groups List Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Groups Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Groups Edit'  , 'guard_name' => 'web',]);
        //Custom Notifications
        Permission::create(['name' => 'Custom Notifications Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom Notifications View'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom Notifications Delete'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom Notifications Employee'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom Notifications Customer'  , 'guard_name' => 'web',]);
        //Custom Pages
        Permission::create(['name' => 'Custom Pages Access'  , 'guard_name' => 'web',]);
        //Pages
        Permission::create(['name' => 'Pages Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Pages Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Pages View'  , 'guard_name' => 'web',]);
        // 404 page 
        Permission::create(['name' => '404 Error Page Access'  , 'guard_name' => 'web',]);
        // Under Maintanance page 
        Permission::create(['name' => 'Under Maintanance Page Access'  , 'guard_name' => 'web',]);
        // App Setting 
        Permission::create(['name' => 'App Setting Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'General Setting Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Ticket Setting Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'SEO Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Google Analytics Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom JS & CSS Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Captcha Setting Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Social Logins Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Email Setting Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Custom Chat Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Maintenance Mode Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'SecruitySetting Access'  , 'guard_name' => 'web',]);
        // Emait to ticket
        Permission::create(['name' => 'Emailtoticket Access'  , 'guard_name' => 'web',]);
        // IpList block
        Permission::create(['name' => 'IpBlock Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'IpBlock Add'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'IpBlock Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'IpBlock Delete'  , 'guard_name' => 'web',]);
        //Announcements
        Permission::create(['name' => 'Announcements Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Announcements Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Announcements Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Announcements Delete'  , 'guard_name' => 'web',]);
        //Email Template
        Permission::create(['name' => 'Email Template Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Email Template Edit'  , 'guard_name' => 'web',]);
        //Reports Template
        Permission::create(['name' => 'Reports Access'  , 'guard_name' => 'web',]);
        
        
        

    }

    public function createRoles(){

        Role::create(['name' => 'superadmin', 'guard_name' => 'web',]);
        // Role::create(['name' => 'agent' , 'guard_name' => 'web',]);
    }

    public function assignPermissions()
	{

        $role = Role::where('name', 'superadmin')->first();
        $permissions = Permission::get();
        foreach ( $permissions as $code ) {
			$role->givePermissionTo($code);
		};
    }

    public function assignRoles()
	{
		
		// $user = User::find(1);
		// $user->assignRole('superadmin');
        // $users = User::find(2);
		// $users->assignRole('agent');



	}
}
