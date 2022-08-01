<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class Setting1TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'key' => 'ENVATO_EXPIRED_BLOCK',
                'value' => 'off',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'MAX_FILE_UPLOAD',
                'value' => '2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'terms_url',
                'value' => '#',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'purchasecode_on',
                'value' => 'off',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'defaultlogin_on',
                'value' => 'off',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'time_format',
                'value' => 'h:i A',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);


           // create permissions
		$this->createPermissions();

        // assign roles and permissions
		$this->assignPermissions();
    }

    public function createPermissions(){

        // App Info
        Permission::create(['name' => 'Pages Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Pages Delete'  , 'guard_name' => 'web',]);

        // Categories
        Permission::create(['name' => 'Categories Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Subcategory Access'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Subcategory Create'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Subcategory Edit'  , 'guard_name' => 'web',]);
        Permission::create(['name' => 'Subcategory Delete'  , 'guard_name' => 'web',]);
    }

    public function assignPermissions()
	{

        $role = Role::where('name', 'Superadmin')->first();
        $permissions = Permission::get();
        foreach ( $permissions as $code ) {
			$role->givePermissionTo($code);
		};
    }
}
