<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use DB;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $mysql_link = @mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
        if (mysqli_connect_errno() || !DB::getSchemaBuilder()->hasTable('settings') ) {
            return;
        }
        
        $config = array(
            'driver'     => @(DB::table('settings')->where('key', 'mail_driver')->first()->value),
            'host'       => @(DB::table('settings')->where('key', 'mail_host')->first()->value),
            'port'       => @(DB::table('settings')->where('key', 'mail_port')->first()->value),
            'from'       => @array('address' => @(DB::table('settings')->where('key', 'mail_from_address')->first()->value), 'name' => @(DB::table('settings')->where('key', 'mail_from_name')->first()->value)),
            'encryption' => @(DB::table('settings')->where('key', 'mail_encryption')->first()->value),
            'username'   => @(DB::table('settings')->where('key', 'mail_username')->first()->value),
            'password'   => @(DB::table('settings')->where('key', 'mail_password')->first()->value),
            'sendmail'   => @'/usr/sbin/sendmail -bs',
            'pretend'    => @false,
        );
        Config::set('mail', $config);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
